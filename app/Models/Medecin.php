<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialite',
        'disponible',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVouses()
    {
        return $this->hasMany(RendezVous::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
