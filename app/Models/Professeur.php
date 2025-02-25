<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'specialite',
        'type_contrat',
        'date_debut',
    ];

    // Relation avec les heures
    public function heures()
    {
        return $this->hasMany(Heure::class);
    }

    // Relation plusieurs-à-plusieurs avec les matières
    
public function matieres()
{
    return $this->belongsToMany(Matiere::class, 'professeur_matiere')
                ->withPivot('classe_id', 'nb_heures','heures_effectuees') // Ajout de nb_heures
                ->withTimestamps();
}
}
