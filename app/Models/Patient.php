<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'nom',
        'prenom',
        'antecedents',
    ];

    protected $casts = [
        'antecedents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }

    // Alias (pour cohérence avec les autres usages)
    public function rendezVouses()
    {
        return $this->hasMany(RendezVous::class, 'patient_id');
    }


    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function prestations()
    {
        return $this->hasMany(Prestation::class);
    }
}
