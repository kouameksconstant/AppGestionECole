<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CahierTexte; // Assurez-vous que cette ligne est bien présente
use App\Models\Professeur;
use App\Models\Matiere;

class CahierTexteController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'professeur_id' => 'required',
            'matiere_id' => 'required',
            'classe_id' => 'required',
            'resume_cours' => 'required|string',
            'heures_effectuees' => 'required|integer|min:1',
        ]);

        CahierTexte::create($request->all());

        return back()->with('success', 'Cours enregistré avec succès !');
    }

    public function view($professeurId)
    {
        $cahierTextes = CahierTexte::where('professeur_id', $professeurId)->get();

        if ($cahierTextes->isEmpty()) {
            return back()->with('error', 'Aucun cahier de texte trouvé.');
        }

        return view('cahier-texte.view', compact('cahierTextes'));
    }
}
