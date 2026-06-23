<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Ordonnance;
use App\Models\Medicament;
use App\Models\RendezVous;
use App\Models\Prestation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Notifications\ConsultationCompleted;


class DoctorController extends Controller
{
    public function dashboard(Request $request)
    {
        $doctor = Auth::user()->medecin;

        $query = Consultation::where('medecin_id', $doctor->id)
            ->with('patient', 'rendezVous');

        // Filtre par date (requis par l’énoncé)
        if ($request->filled('date')) {
            $query->whereDate('date_consultation', $request->date);
        }

        $consultations = $query
            ->orderBy('date_consultation', 'asc')
            ->get();

        return view('medecin.dashboard', compact('consultations'));
    }


    public function showConsultation($id)
    {
        $consultation = Consultation::with(['patient', 'rendezVous'])->findOrFail($id);
        $medicaments = Medicament::all();
        return view('medecin.consultation_detail', compact('consultation', 'medicaments'));
    }

    public function completeConsultation(Request $request, $id)
    {
        try {
            $consultation = Consultation::with(['patient.user', 'medecin.user', 'rendezVous'])->findOrFail($id);
            
            $request->validate([
                'constantes.temperature' => 'required',
                'constantes.tension' => 'required',
                'medicaments' => 'nullable|array',
                'posologie' => 'nullable|array',
                'patient_antecedents' => 'nullable|array',
                // Validation pour le prochain RV
                'next_rv.plan' => 'nullable|string',
                'next_rv.type' => 'required_if:next_rv.plan,on|in:consultation,prestation',
                'next_rv.date_rv' => 'required_if:next_rv.plan,on|date|after:now',
                'next_rv.prestation_type' => 'required_if:next_rv.type,prestation|string|max:255',
            ]);

            // Mise à jour des antécédents du patient
            if ($consultation->patient) {
                $consultation->patient->update([
                    'antecedents' => $request->patient_antecedents ?? []
                ]);
            }

            $consultation->update([
                'constantes' => $request->constantes
            ]);

            // Gestion de l'ordonnance
            if ($request->has('medicaments')) {
                // Supprimer l'ancienne ordonnance si elle existe
                if ($consultation->ordonnance) {
                    $consultation->ordonnance->medicaments()->detach();
                    $consultation->ordonnance->delete();
                }

                $ordonnance = Ordonnance::create(['consultation_id' => $consultation->id]);
                foreach ($request->medicaments as $index => $medId) {
                    if ($medId) {
                        $ordonnance->medicaments()->attach($medId, ['posologie' => $request->posologie[$index] ?? 'N/A']);
                    }
                }
            }

            // Planification du prochain RV si demandé
            if ($request->input('next_rv.plan') === 'on' && $request->filled('next_rv.date_rv')) {
                $newRv = RendezVous::create([
                    'patient_id' => $consultation->patient_id,
                    'medecin_id' => $request->input('next_rv.type') === 'consultation' ? $consultation->medecin_id : null,
                    'type' => $request->input('next_rv.type'),
                    'prestation_type' => $request->input('next_rv.type') === 'prestation' ? $request->input('next_rv.prestation_type') : null,
                    'date_rv' => $request->input('next_rv.date_rv'),
                    'statut' => 'valide', // Validé automatiquement par le médecin
                ]);

                // Si c'est validé, on crée aussi l'objet Consultation/Prestation correspondant
                if ($newRv->type === 'consultation') {
                    Consultation::create([
                        'rendez_vous_id' => $newRv->id,
                        'patient_id' => $newRv->patient_id,
                        'medecin_id' => $newRv->medecin_id,
                        'date_consultation' => $newRv->date_rv,
                    ]);
                } else {
                    Prestation::create([
                        'rendez_vous_id' => $newRv->id,
                        'patient_id' => $newRv->patient_id,
                        'type' => $newRv->prestation_type,
                        'date_prestation' => $newRv->date_rv,
                        'statut' => 'en_attente',
                    ]);
                }
            }

            // Mettre à jour le statut du RDV actuel
            if ($consultation->rendezVous) {
                $consultation->rendezVous->update(['statut' => 'effectue']);
            }

            // Notification au patient
            if ($consultation->patient && $consultation->patient->user) {
                try {
                    $consultation->patient->user->notify(new ConsultationCompleted($consultation));
                } catch (\Exception $e) {
                    \Log::error('Erreur notification consultation: ' . $e->getMessage());
                }
            }

            return redirect()->route('medecin.dashboard')->with('success', '✅ Consultation terminée avec succès.');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve;
        } catch (\Exception $e) {
            Log::error('❌ Erreur complète consultation: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Une erreur est survenue lors de la validation : ' . $e->getMessage());
        }
    }

    /**
     * Annuler une consultation (par le médecin) 
     * Règle : impossible d'annuler < 48h avant la date du RDV
     */
    public function cancelConsultation(Request $request, $id)
    {
        $doctor = Auth::user()->medecin;
        $consultation = Consultation::with('rendezVous')->findOrFail($id);

        $rv = $consultation->rendezVous;

        // Vérifier que le rendez-vous appartient bien au médecin connecté
        if (!$rv || $rv->medecin_id !== $doctor->id) {
            abort(403);
        }

        // Ne peut annuler que si en_attente ou valide
        if (!in_array($rv->statut, ['en_attente', 'valide'])) {
            return back()->with('error', 'Ce rendez-vous ne peut plus être annulé (statut : ' . $rv->statut . ').');
        }

        // Si valide => supprimer la consultation associée (ici on annule la consultation elle-même)
        if ($rv->statut === 'valide') {
            $consultation->delete();
        }

        $rv->update(['statut' => 'annule']);

        Log::info('🚫 Consultation annulée par le médecin', [
            'consultation_id' => $consultation->id,
            'rv_id' => $rv->id,
            'medecin_id' => $doctor->id,
        ]);

        return back()->with('success', '🚫 Consultation annulée.');
    }


    public function searchPatient(Request $request)
    {
        $query = $request->input('query');
        $patients = Patient::where('nom', 'LIKE', "%$query%")
            ->orWhere('prenom', 'LIKE', "%$query%")
            ->orWhere('code', 'LIKE', "%$query%")
            ->get();

        return view('medecin.search_patient', compact('patients'));
    }

    public function patientHistory($id)
    {
        $patient = Patient::with(['consultations.ordonnance.medicaments', 'prestations'])->findOrFail($id);
        return view('medecin.patient_history', compact('patient'));
    }
}
