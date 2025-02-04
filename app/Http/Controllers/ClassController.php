<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe; // Assurez-vous que le modèle Classe existe

class ClassController extends Controller
{
    /**
     * Affiche la gestion d'une classe spécifique.
     * 
     * @param  int  $class L'identifiant de la classe
     * @return \Illuminate\View\View
     */
    public function manage($class)
    {
        // Récupérer la classe depuis la base de données
        $classData = Classe::find($class);
        
        // Si la classe n'existe pas, afficher une erreur 404
        if (!$classData) {
            abort(404, 'Classe non trouvée');
        }

        // Retourner la vue avec les données de la classe
        return view('class.manage', compact('classData'));
    }

    /**
     * Enregistrer une nouvelle classe dans la base de données.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Validation pour le nom
            'description' => 'required|string|max:500', // Validation pour la description
        ]);

        // Créer une nouvelle instance de Classe
        $class = new Classe();
        $class->name = $validated['name']; // Assigner le nom de la classe
        $class->description = $validated['description']; // Assigner la description
        $class->save(); // Sauvegarder la classe dans la base de données

        // Rediriger vers la liste des classes avec un message de succès
        return redirect()->route('classe.index')->with('success', 'Classe créée avec succès!');
    }

    /**
     * Afficher le formulaire de création d'une nouvelle classe.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('adminlte.classe.create');
    }
}
