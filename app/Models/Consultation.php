<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'rendez_vous_id',
        'patient_id',
        'medecin_id',
        'constantes',
        'date_consultation',
    ];

    protected $casts = [
        'constantes' => 'array',
        'date_consultation' => 'datetime',
    ];

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function ordonnance()
    {
        return $this->hasOne(Ordonnance::class);
    }
}
