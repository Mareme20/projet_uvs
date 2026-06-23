<?php

namespace Database\Seeders;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Consultation;
use App\Models\Prestation;
use App\Models\Ordonnance;
use App\Models\Medicament;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $medecins = Medecin::all();
        $medicaments = Medicament::all();

        if ($patients->isEmpty() || $medecins->isEmpty()) {
            return;
        }

        // 1. Pending Consultation
        RendezVous::create([
            'patient_id' => $patients[0]->id,
            'medecin_id' => $medecins[0]->id,
            'type' => 'consultation',
            'date_rv' => Carbon::tomorrow()->setHour(10),
            'statut' => 'en_attente',
        ]);

        // 2. Validated Consultation (Today) -> transformed to Consultation
        $rv2 = RendezVous::create([
            'patient_id' => $patients[1]->id,
            'medecin_id' => $medecins[0]->id,
            'type' => 'consultation',
            'date_rv' => Carbon::today()->setHour(14),
            'statut' => 'valide',
        ]);
        Consultation::create([
            'rendez_vous_id' => $rv2->id,
            'patient_id' => $rv2->patient_id,
            'medecin_id' => $rv2->medecin_id,
            'date_consultation' => $rv2->date_rv,
        ]);

        // 3. Completed Consultation (Yesterday)
        $rv3 = RendezVous::create([
            'patient_id' => $patients[2]->id,
            'medecin_id' => $medecins[1]->id,
            'type' => 'consultation',
            'date_rv' => Carbon::yesterday()->setHour(11),
            'statut' => 'effectue',
        ]);
        $cons3 = Consultation::create([
            'rendez_vous_id' => $rv3->id,
            'patient_id' => $rv3->patient_id,
            'medecin_id' => $rv3->medecin_id,
            'date_consultation' => $rv3->date_rv,
            'constantes' => ['temperature' => '37.5', 'tension' => '12/8'],
        ]);
        $ord3 = Ordonnance::create(['consultation_id' => $cons3->id]);
        $ord3->medicaments()->attach($medicaments[0]->id, ['posologie' => '1 comprimé 3 fois par jour']);

        // 4. Cancelled Consultation (Today)
        RendezVous::create([
            'patient_id' => $patients[3]->id,
            'medecin_id' => $medecins[2]->id,
            'type' => 'consultation',
            'date_rv' => Carbon::today()->setHour(9),
            'statut' => 'annule',
        ]);

        // 5. Prestation (Today)
        $rv5 = RendezVous::create([
            'patient_id' => $patients[0]->id,
            'type' => 'prestation',
            'prestation_type' => 'Analyse Sanguine',
            'date_rv' => Carbon::today()->setHour(15),
            'statut' => 'valide',
        ]);
        Prestation::create([
            'rendez_vous_id' => $rv5->id,
            'patient_id' => $rv5->patient_id,
            'type' => 'Analyse Sanguine',
            'date_prestation' => $rv5->date_rv,
            'statut' => 'en_attente',
        ]);

        // 6. Completed Prestation
        $rv6 = RendezVous::create([
            'patient_id' => $patients[1]->id,
            'type' => 'prestation',
            'prestation_type' => 'Radio Thorax',
            'date_rv' => Carbon::yesterday()->setHour(16),
            'statut' => 'effectue',
        ]);
        Prestation::create([
            'rendez_vous_id' => $rv6->id,
            'patient_id' => $rv6->patient_id,
            'type' => 'Radio Thorax',
            'date_prestation' => $rv6->date_rv,
            'statut' => 'effectue',
            'resultats' => 'Poumons clairs, pas de signe de pneumonie.',
        ]);
    }
}
