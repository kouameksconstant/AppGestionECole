<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'enregistrement.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Retourne la vue d'enregistrement personnalisée dans le répertoire adminlte
        return view('adminlte.register');
    }

    // Ajoute ici la logique pour traiter l'enregistrement si nécessaire (si tu veux une logique spécifique)
}
