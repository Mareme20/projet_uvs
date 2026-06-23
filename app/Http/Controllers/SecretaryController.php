<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Prestation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SecretaryController extends Controller
{
    /**
     * Dashboard : liste des rendez-vous filtrés par statut
     */
    public function dashboard(Request $request)
    {
        $statut = $request->input('statut', 'en_attente');

        $pendingRVs = RendezVous::where('statut', $statut)
            ->with(['patient', 'medecin.user'])
            ->orderBy('date_rv', 'asc')
            ->get();

        $counts = [
            'en_attente' => RendezVous::where('statut', 'en_attente')->count(),
            'valide' => RendezVous::where('statut', 'valide')->count(),
            'effectue' => RendezVous::where('statut', 'effectue')->count(),
            'annule' => RendezVous::where('statut', 'annule')->count(),
        ];

        return view('secretaire.dashboard', compact('pendingRVs', 'counts'));
    }

    /**
     * Valider un rendez-vous
     */
    public function validateRV(Request $request, $id)
    {
        $rv = RendezVous::findOrFail($id);

        // Vérifier que le RDV est bien en attente
        if ($rv->statut !== 'en_attente') {
            return back()->with('error', 'Ce rendez-vous ne peut plus être validé (statut : ' . $rv->statut . ').');
        }

        // Vérification de disponibilité (Optionnel mais demandé par l'énoncé)
        if ($rv->type === 'consultation' && $rv->medecin_id) {
            $exists = RendezVous::where('medecin_id', $rv->medecin_id)
                ->where('date_rv', $rv->date_rv)
                ->whereIn('statut', ['valide', 'effectue'])
                ->exists();
            
            if ($exists) {
                return back()->with('error', '⚠️ Le médecin n\'est pas disponible à cet horaire (déjà un rendez-vous).');
            }
        }

        // Mettre à jour le statut
        $rv->update(['statut' => 'valide']);

        // Créer la consultation ou la prestation
        if ($rv->type === 'consultation') {
            Consultation::create([
                'rendez_vous_id' => $rv->id,
                'patient_id' => $rv->patient_id,
                'medecin_id' => $rv->medecin_id,
                'date_consultation' => $rv->date_rv,
            ]);

            \Log::info('✅ Consultation créée', [
                'rv_id' => $rv->id,
                'patient_id' => $rv->patient_id,
                'medecin_id' => $rv->medecin_id,
            ]);
        } else {
            Prestation::create([
                'rendez_vous_id' => $rv->id,
                'patient_id' => $rv->patient_id,
                'type' => $rv->prestation_type,
                'date_prestation' => $rv->date_rv,
                'statut' => 'en_attente',
            ]);

            \Log::info('✅ Prestation créée', [
                'rv_id' => $rv->id,
                'patient_id' => $rv->patient_id,
                'type' => $rv->prestation_type,
            ]);
        }

        return back()->with('success', '✅ Rendez-vous validé et transformé avec succès.');
    }

    /**
     * Annuler un rendez-vous (par la secrétaire)
     */
    public function cancelRV(Request $request, $id)
    {
        $rv = RendezVous::findOrFail($id);

        // Ne peut annuler que si en_attente ou valide
        if (!in_array($rv->statut, ['en_attente', 'valide'])) {
            return back()->with('error', 'Ce rendez-vous ne peut pas être annulé (statut : ' . $rv->statut . ').');
        }

        // Si déjà valide, supprimer la consultation/prestation associée
        if ($rv->statut === 'valide') {
            if ($rv->type === 'consultation' && $rv->consultation) {
                $rv->consultation->delete();
            }
            if ($rv->type === 'prestation' && $rv->prestation) {
                $rv->prestation->delete();
            }
        }

        $rv->update(['statut' => 'annule']);

        return back()->with('success', '🚫 Rendez-vous annulé.');
    }

    /**
     * Marquer un rendez-vous comme effectué
     */
    public function completeRV(Request $request, $id)
    {
        $rv = RendezVous::findOrFail($id);

        // Ne peut terminer que si valide
        if ($rv->statut !== 'valide') {
            return back()->with('error', 'Ce rendez-vous ne peut pas être marqué comme effectué (statut : ' . $rv->statut . ').');
        }

        $rv->update(['statut' => 'effectue']);

        // Mettre à jour la prestation si c'en est une
        if ($rv->type === 'prestation' && $rv->prestation) {
            $rv->prestation->update(['statut' => 'effectue']);
        }

        return back()->with('success', '✅ Rendez-vous marqué comme effectué.');
    }
}
