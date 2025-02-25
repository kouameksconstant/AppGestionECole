<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function heures()
    {
        return $this->hasMany(Heure::class, 'matiere_id');
    }

    public function professeurs()
{
    return $this->belongsToMany(Professeur::class, 'professeur_matiere')
                ->withPivot('classe_id', 'nb_heures','heures_effectuees')
                ->withTimestamps();
}

}
