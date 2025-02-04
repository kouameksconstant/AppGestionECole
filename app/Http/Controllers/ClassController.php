<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe; // Assurez-vous que le modèle Classe existe
use Illuminate\Support\Facades\Session;

class ClassController extends Controller
{
    /**
     * Affiche la liste des classes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $classes = Classe::all(); // Récupère toutes les classes
        return view('adminlte.classes.index', compact('classes'));
    }

    /**
     * Affiche la gestion d'une classe spécifique.
     *
     * @param  int  $class L'identifiant de la classe
     * @return \Illuminate\View\View
     */
    public function manage($class)
    {
        $classData = Classe::find($class);

        if (!$classData) {
            return redirect()->route('classes.index')->with('error', 'Classe non trouvée!');
        }

        return view('adminlte.classe.manage', compact('classData'));
    }

    /**
     * Enregistrer une nouvelle classe dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validation des données entrées
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        // Création de la classe
        Classe::create($validated);

        // Retourner une réponse avec un message de succès
        return redirect()->route('classes.index')->with('success', 'Classe créée avec succès!');
    }

    /**
     * Afficher le formulaire de création d'une nouvelle classe.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('adminlte.classes.create');
    }

    /**
     * Met à jour les informations d'une classe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id L'identifiant de la classe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validation des données entrées
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:500',
        ]);

        // Trouver la classe à mettre à jour
        $class = Classe::find($id);

        if (!$class) {
            return redirect()->route('classes.index')->with('error', 'Classe non trouvée!');
        }

        // Mise à jour de la classe
        $class->update($validated);

        // Retourner avec un message de succès
        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès!');
    }

    /**
     * Supprime une classe.
     *
     * @param  int  $id L'identifiant de la classe
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Trouver la classe à supprimer
        $class = Classe::find($id);

        if (!$class) {
            return redirect()->route('classes.index')->with('error', 'Classe non trouvée!');
        }

        // Suppression de la classe
        $class->delete();

        // Retourner avec un message de succès
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès!');
    }
}
