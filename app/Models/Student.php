<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Déclare les champs qui peuvent être remplis par le formulaire
    protected $fillable = [
        'name',
        'prenom', // Nouveau champ
        'email',
        'tel_perso', // Nouveau champ
        'birth_date',
        'lieu_naissance', // Nouveau champ
        'class_id', // Correction du nom de la colonne de classe
        'filiere_id', // Ajout de la filière
    ];

    // Relation avec la table des classes
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class_id'); // Utiliser le modèle 'Classe'
    }

    // Relation avec la table des filières
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'filiere_id');
    }
}
