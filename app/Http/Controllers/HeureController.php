<?php
namespace App\Http\Controllers;

use App\Models\Heure;
use App\Models\Matiere;
use App\Models\Professeur;
use Illuminate\Http\Request;

class HeureController extends Controller
{
    /**
     * Afficher la liste des heures enregistrées.
     */
    public function index()
    {
        $heures = Heure::with('matiere')->get(); // Charge la relation matiere
        $professeurs = Professeur::with(['matieres', 'heures'])->paginate(10); // Ajout de la pagination

        return view('heures.index', compact('heures', 'professeurs'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle heure.
     */
    public function create()
    {
        $matieres = Matiere::all(); // Récupère toutes les matières pour le formulaire
        return view('heures.create', compact('matieres'));
    }

    /**
     * Enregistrer une nouvelle heure en base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'matiere_id' => 'required|exists:matieres,id',
            'heure' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Heure::create($request->all());

        return redirect()->route('heures.index')->with('success', 'Heure ajoutée avec succès.');
    }

    /**
     * Afficher le formulaire de modification d'une heure.
     */
    public function edit(Professeur $professeur, Heure $heure)
    {
        $matieres = Matiere::all();
        return view('heures.edit', compact('heure', 'matieres', 'professeur'));
    }

    /**
     * Mettre à jour une heure existante.
     */
    public function update(Request $request, Professeur $professeur, Heure $heure)
    {
        $request->validate([
            'matiere_id' => 'required|exists:matieres,id',
            'heure' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $heure->update($request->all());

        return redirect()->route('heures.index')->with('success', 'Heure mise à jour avec succès.');
    }

    /**
     * Supprimer une heure.
     */
    public function destroy(Professeur $professeur, Heure $heure)
    {
        $heure->delete();
        return redirect()->route('heures.index')->with('success', 'Heure supprimée avec succès.');
    }
}
