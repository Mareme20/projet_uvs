<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RendezVous extends Model
{
    protected $table = 'rendez_vouses'; // ⚠️ Vérifie le nom exact de ta table

    protected $fillable = [
        'patient_id',
        'medecin_id',
        'type',
        'prestation_type',
        'date_rv',
        'statut',
    ];

    protected $casts = [
        'date_rv' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class);
    }

    public function consultation(): HasOne
    {
        return $this->hasOne(Consultation::class, 'rendez_vous_id');
    }

    public function prestation(): HasOne
    {
        return $this->hasOne(Prestation::class, 'rendez_vous_id');
    }

    // Scopes utiles
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopeValide($query)
    {
        return $query->where('statut', 'valide');
    }

    public function scopeAnnule($query)
    {
        return $query->where('statut', 'annule');
    }

    public function scopeEffectue($query)
    {
        return $query->where('statut', 'effectue');
    }
}