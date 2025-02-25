<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierTexte extends Model
{
    use HasFactory;

    protected $table = 'cahier_textes'; // Assurez-vous que le nom correspond à la table

    protected $fillable = [
        'professeur_id',
        'matiere_id',
        'classe_id',
        'resume_cours',
        'heures_effectuees'
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
