<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    protected $casts = [
        'date_debut' => 'date:Y-m-d', // Assurer un formatage correct des dates
        'date_fin' => 'date:Y-m-d',
    ];

    public function heures()
    {
        return $this->hasMany(Heure::class, 'matiere_id');
    }

    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'professeur_matiere')
                    ->withPivot('classe_id', 'nb_heures', 'heures_effectuees', 'date_debut', 'date_fin')
                    ->withTimestamps();
    }

    // Accesseur pour bien formater les dates
    public function getDateDebutAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }

    public function getDateFinAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d/m/Y') : null;
    }
}
