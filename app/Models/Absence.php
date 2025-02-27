<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'professeur_id',
        'matiere_id',
        'classe_id',
        'date_absence',
        'duree',
        'motif',
        'statut',
        'justificatif'
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
