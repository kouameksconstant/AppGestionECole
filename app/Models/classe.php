<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    // Si le nom de la table n'est pas "classes", spécifiez-le ici (optionnel)
    protected $table = 'classes';

    // Définir les colonnes qui peuvent être assignées en masse
    protected $fillable = ['name'];

    // Si vous avez une clé primaire personnalisée, spécifiez-la ici
    // protected $primaryKey = 'id';

    // Définir la relation avec les étudiants (optionnel si vous avez besoin de récupérer tous les étudiants d'une classe)
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
