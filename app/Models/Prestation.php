<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rendez_vous_id',
        'patient_id',
        'type',
        'date_prestation',
        'statut',
        'resultats',
        'fichier_resultat',
    ];

    protected $casts = [
        'date_prestation' => 'datetime',
    ];

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
