<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Consultation;
use App\Models\Prestation;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());

        // Médecins disponibles (Calculé : ceux qui ont moins de 10 RV validés pour ce jour)
        $medecinsDisponibles = Medecin::with(['user', 'rendezVouses' => function($q) use ($date) {
            $q->whereDate('date_rv', $date)->whereIn('statut', ['valide', 'effectue']);
        }])->get()->filter(function($med) {
            return $med->rendezVouses->count() < 10;
        });

        // Prestations du Jour
        $prestationsDuJour = Prestation::whereDate('date_prestation', $date)->with('patient')->get();

        // Consultations du jour
        $consultationsDuJour = Consultation::whereDate('date_consultation', $date)->with(['patient', 'medecin.user'])->get();

        // Consultations annulées du Jour
        $consultationsAnnulees = RendezVous::where('type', 'consultation')
            ->where('statut', 'annule')
            ->whereDate('date_rv', $date)
            ->with(['patient', 'medecin.user'])
            ->get();

        return view('statistics.index', compact(
            'date', 
            'medecinsDisponibles', 
            'prestationsDuJour', 
            'consultationsDuJour', 
            'consultationsAnnulees'
        ));
    }
}
