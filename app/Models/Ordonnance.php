<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;

    protected $fillable = [
        'consultation_id',
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function medicaments()
    {
        return $this->belongsToMany(Medicament::class, 'ordonnance_medicaments')
                    ->withPivot('posologie')
                    ->withTimestamps();
    }
}
