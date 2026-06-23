<?php

namespace App\Http\Controllers;

use App\Models\Prestation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Notifications\PrestationResultReady;

class PrestationManagerController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Prestation::with('patient');

        if ($request->has('date')) {
            $query->whereDate('date_prestation', $request->date);
        }

        $prestations = $query->orderBy('date_prestation', 'asc')->get();

        return view('responsable_prestation.dashboard', compact('prestations'));
    }

    public function show($id)

    {
        $prestation = Prestation::with('patient')->findOrFail($id);
        return view('responsable_prestation.detail', compact('prestation'));
    }

    public function updateResultats(Request $request, $id)
    {
        $prestation = Prestation::with('patient.user')->findOrFail($id);
        
        $request->validate([
            'resultats' => 'required|string',
            'fichier_resultat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'resultats' => $request->resultats,
            'statut' => 'effectue'
        ];

        if ($request->hasFile('fichier_resultat')) {
            $path = $request->file('fichier_resultat')->store('prestations/resultats', 'public');
            $data['fichier_resultat'] = $path;
        }

        $prestation->update($data);

        $prestation->rendezVous->update(['statut' => 'effectue']);

        // Notification au patient
        if ($prestation->patient && $prestation->patient->user) {
            $prestation->patient->user->notify(new PrestationResultReady($prestation));
        }

        return redirect()->route('responsable.dashboard')->with('success', 'Résultats importés avec succès et patient notifié.');
    }

    /**
     * Annuler une prestation (par le responsable)
     */
    public function cancelPrestation(Request $request, $id)
    {
        $prestation = Prestation::with('rendezVous')->findOrFail($id);
        $rv = $prestation->rendezVous;

        if (!$rv) {
            return back()->with('error', 'Impossible d\'annuler : rendez-vous introuvable.');
        }

        // Ne peut annuler que si en_attente ou valide
        if (!in_array($rv->statut, ['en_attente', 'valide'])) {
            return back()->with('error', 'Ce rendez-vous ne peut pas être annulé (statut : ' . $rv->statut . ').');
        }

        // Si déjà valide => supprimer la prestation associée
        if ($rv->statut === 'valide') {
            $prestation->delete();
        }

        $rv->update(['statut' => 'annule']);

        Log::info('🚫 Prestation annulée par le responsable', [
            'prestation_id' => $prestation->id,
            'rv_id' => $rv->id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', '🚫 Prestation annulée.');
    }
}
