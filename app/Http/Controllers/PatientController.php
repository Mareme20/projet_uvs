<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Medecin;
use App\Models\Consultation;
use App\Models\Prestation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $patient = $user?->patient;

        $appointments = collect();
        if ($patient) {
            $appointments = RendezVous::where('patient_id', $patient->id)
                ->with(['medecin.user', 'consultation.ordonnance.medicaments', 'prestation'])
                ->orderBy('date_rv', 'desc')
                ->get();
        }

        return view('patient.dashboard', compact('appointments'));
    }

    public function createAppointment()
    {
        $doctors = Medecin::with('user')->get();
        return view('patient.create_rv', compact('doctors'));
    }

    public function storeAppointment(Request $request)
    {
        $user = Auth::user();
        $patient = $user?->patient;

        if (!$patient) {
            return back()->with('error', 'Profil patient introuvable.');
        }

        // Validation
        $rules = [
            'type' => 'required|in:consultation,prestation',
            'date_rv' => 'required|date|after:now',
        ];

        if ($request->type === 'consultation') {
            $rules['medecin_id'] = 'required|exists:medecins,id';
        }
        if ($request->type === 'prestation') {
            $rules['prestation_type'] = 'required|string|max:255';
        }

        $request->validate($rules, [
            'type.required' => 'Veuillez choisir un type de rendez-vous.',
            'type.in' => 'Type de rendez-vous invalide.',
            'medecin_id.required' => 'Veuillez sélectionner un médecin.',
            'medecin_id.exists' => 'Ce médecin n\'existe pas.',
            'prestation_type.required' => 'Veuillez préciser le type de prestation.',
            'date_rv.required' => 'Veuillez choisir une date.',
            'date_rv.date' => 'Format de date invalide.',
            'date_rv.after' => 'La date doit être dans le futur.',
        ]);

        try {
            RendezVous::create([
                'patient_id' => $patient->id,
                'medecin_id' => $request->type === 'consultation' ? $request->medecin_id : null,
                'type' => $request->type,
                'prestation_type' => $request->type === 'prestation' ? $request->prestation_type : null,
                'date_rv' => $request->date_rv,
                'statut' => 'en_attente',
            ]);

            return redirect()
                ->route('patient.dashboard')
                ->with('success', '✅ Votre demande de rendez-vous a été envoyée. Elle sera validée par notre secrétaire.');

        } catch (\Throwable $e) {
            \Log::error('❌ Échec création RV', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    /**
     * Annuler un rendez-vous (par le patient)
     * Règle : impossible si < 48h de la date du RDV
     */
    public function cancelAppointment($id)
    {
        $patient = Auth::user()?->patient;

        if (!$patient) {
            return back()->with('error', 'Profil patient introuvable.');
        }

        $appointment = RendezVous::findOrFail($id);

        // Vérifier que le RDV appartient au patient
        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }

        // Vérifier le statut : ne peut annuler que si en_attente ou valide
        if (!in_array($appointment->statut, ['en_attente', 'valide'])) {
            return back()->with('error', 'Ce rendez-vous ne peut plus être annulé (statut : ' . $appointment->statut . ').');
        }

        // Vérifier le délai de 48h
        $rvDate = Carbon::parse($appointment->date_rv);
        $now = Carbon::now();
        $hoursUntil = $now->diffInHours($rvDate, false);

        if ($hoursUntil < 48) {
            return back()->with(
                'error',
                '⚠️ Impossible d\'annuler : une consultation ou prestation ne peut être annulée moins de 48h avant sa date.'
            );
        }

        // Si le RDV était déjà validé, supprimer la consultation/prestation
        if ($appointment->statut === 'valide') {
            if ($appointment->type === 'consultation' && $appointment->consultation) {
                $appointment->consultation->delete();
            }
            if ($appointment->type === 'prestation' && $appointment->prestation) {
                $appointment->prestation->delete();
            }
        }

        $appointment->update(['statut' => 'annule']);

        \Log::info('🚫 RV annulé par patient', [
            'rv_id' => $appointment->id,
            'patient_id' => $patient->id,
        ]);

        return back()->with('success', '✅ Rendez-vous annulé avec succès.');
    }

    /**
     * Imprimer une ordonnance
     */
    public function printConsultation($id)
    {
        $patientId = Auth::user()->patient->id;
        $consultation = Consultation::where('id', $id)
            ->where('patient_id', $patientId)
            ->with(['patient', 'medecin.user', 'ordonnance.medicaments'])
            ->firstOrFail();

        return view('patient.print_ordonnance', compact('consultation'));
    }

    /**
     * Imprimer les résultats d'une prestation
     */
    public function printPrestation($id)
    {
        $patientId = Auth::user()->patient->id;
        $prestation = Prestation::where('id', $id)
            ->where('patient_id', $patientId)
            ->with(['patient', 'rendezVous.medecin.user'])
            ->firstOrFail();

        return view('patient.print_prestation', compact('prestation'));
    }
}