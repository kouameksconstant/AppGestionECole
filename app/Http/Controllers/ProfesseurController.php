<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Absence; // Assurez-vous que le modèle Absence existe et que ses relations sont définies
use Illuminate\Support\Facades\Storage;

class ProfesseurController extends Controller
{
    // Affichage de la liste des professeurs avec pagination
    public function index()
    {
        $professeurs = Professeur::paginate(10); // 10 professeurs par page
        return view('professeurs.index', compact('professeurs'));
    }

    // Affichage du formulaire de création
    public function create()
    {
        return view('professeurs.create');
    }

    // Enregistrement d'un professeur
    public function store(Request $request)
    {
        // Validation des champs
        $request->validate([
            'nom'          => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'email'        => 'required|email|unique:professeurs,email',
            'telephone'    => 'required|string|max:20',
            'specialite'   => 'required|string|max:255',
            'type_contrat' => 'required|string|max:255',
            'date_debut'   => 'required|date',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Gestion de l'upload de la photo
        $photoPath = $request->file('photo')
            ? $request->file('photo')->store('professeurs', 'public')
            : null;

        // Enregistrement du professeur
        Professeur::create([
            'nom'          => $request->nom,
            'prenom'       => $request->prenom,
            'email'        => $request->email,
            'telephone'    => $request->telephone,
            'specialite'   => $request->specialite,
            'type_contrat' => $request->type_contrat,
            'date_debut'   => $request->date_debut,
            'photo'        => $photoPath,
        ]);

        return redirect()->route('professeurs.index')
                         ->with('success', 'Professeur ajouté avec succès !');
    }

    // Affichage d'un professeur
    public function show($id)
    {
        $professeur = Professeur::findOrFail($id);
        return view('professeurs.show', compact('professeur'));
    }

    // Affichage du formulaire de modification
    public function edit($id)
    {
        $professeur = Professeur::findOrFail($id);
        return view('professeurs.edit', compact('professeur'));
    }

    // Mise à jour d'un professeur
    public function update(Request $request, $id)
    {
        $professeur = Professeur::findOrFail($id);

        // Validation
        $request->validate([
            'nom'          => 'required|string|max:255',
            'prenom'       => 'required|string|max:255',
            'email'        => 'required|email|unique:professeurs,email,' . $id,
            'telephone'    => 'required|string|max:20',
            'specialite'   => 'required|string|max:255',
            'type_contrat' => 'required|string|max:255',
            'date_debut'   => 'required|date',
            'photo'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Gestion de l'upload de la nouvelle photo
        if ($request->hasFile('photo')) {
            if ($professeur->photo) {
                Storage::disk('public')->delete($professeur->photo);
            }
            $photoPath = $request->file('photo')->store('professeurs', 'public');
            $professeur->photo = $photoPath;
        }

        $professeur->fill($request->except('photo'))->save();

        return redirect()->route('professeurs.index')
                         ->with('success', 'Professeur mis à jour avec succès !');
    }

    // Méthode pour déclarer une absence
    public function marquerAbsence(Request $request, $id)
    {
        $request->validate([
            'date_absence' => 'required|date',
            'duree'        => 'required|integer|min:1',
            'motif'        => 'nullable|string',
            'matiere_id'   => 'required|exists:matieres,id',
            'classe_id'    => 'required|exists:classes,id',
        ]);

        Absence::create([
            'professeur_id' => $id,
            'matiere_id'    => $request->input('matiere_id'),
            'classe_id'     => $request->input('classe_id'),
            'date_absence'  => $request->input('date_absence'),
            'duree'         => $request->input('duree'),
            'motif'         => $request->input('motif'),
            'statut'        => 'en attente'
        ]);

        return redirect()->back()->with('success', 'Absence déclarée avec succès.');
    }

    // Suppression d'un professeur
    public function destroy($id)
    {
        $professeur = Professeur::findOrFail($id);
        if ($professeur->photo) {
            Storage::disk('public')->delete($professeur->photo);
        }
        $professeur->delete();
        return redirect()->route('professeurs.index')
                         ->with('success', 'Professeur supprimé avec succès !');
    }
}
