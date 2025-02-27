<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CahierTexte;
use App\Models\Professeur;
use App\Models\Matiere;
use App\Models\Classe;

class CahierTexteController extends Controller
{
    public function view($professeur_id)
    {
        $professeur = Professeur::findOrFail($professeur_id);
        $cahierTextes = CahierTexte::where('professeur_id', $professeur_id)->get();

        return view('cahier.view', compact('cahierTextes', 'professeur'));
    }

    public function show($id)
    {
        $cahierTexte = CahierTexte::findOrFail($id);
        return view('cahier.show', compact('cahierTexte'));
    }

    public function create()
    {
        $professeurs = Professeur::all();
        $matieres = Matiere::all();
        $classes = Classe::all();

        return view('cahier.create', compact('professeurs', 'matieres', 'classes'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'professeur_id' => 'required|exists:professeurs,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'contenu' => 'required|string',
        ]);

        CahierTexte::create([
            'professeur_id' => $request->professeur_id,
            'matiere_id' => $request->matiere_id,
            'classe_id' => $request->classe_id,
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('cahier.view', $request->professeur_id)
                         ->with('success', 'Cahier de texte enregistré avec succès.');
    }

    public function viewCahier($id)
    {
        $professeur = Professeur::with(['matieres' => function ($query) {
            $query->withPivot('date_debut', 'date_fin', 'nb_heures', 'heures_effectuees');
        }])->find($id);

        if (!$professeur) {
            return redirect()->back()->with('error', 'Professeur introuvable.');
        }

        $classes = Classe::all();
        $cahierTextes = CahierTexte::where('professeur_id', $id)->with(['matiere', 'classe'])->get();

        return view('cahier.view', compact('cahierTextes', 'professeur', 'classes'));
    }

    public function filtrer(Request $request)
    {
        $professeur_id = $request->input('professeur_id');
        $classe_id = $request->input('classe_id');

        $query = CahierTexte::query();

        if ($professeur_id) {
            $query->where('professeur_id', $professeur_id);
        }
        if ($classe_id) {
            $query->where('classe_id', $classe_id);
        }

        $cahierTextes = $query->get();

        return view('cahier.view', compact('cahierTextes'));
    }
}
