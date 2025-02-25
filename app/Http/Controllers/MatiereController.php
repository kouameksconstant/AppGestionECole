<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Matiere;
use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Exception;

class MatiereController extends Controller
{
    public function assign()
    {
        $professeurs = Professeur::all();
        $matieres = Matiere::all();
        $classes = Classe::all();

        if ($professeurs->isEmpty() || $matieres->isEmpty() || $classes->isEmpty()) {
            return back()->with('error', 'Assurez-vous d’avoir ajouté des professeurs, matières et classes.');
        }

        return view('matieres.assign', compact('professeurs', 'matieres', 'classes'));
    }

    public function saveAssignment(Request $request)
    {
        $request->validate([
            'professeur_id' => 'required|exists:professeurs,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'nb_heures' => 'required|integer|min:1',
        ]);

        try {
            // Vérifier si l'assignation existe déjà
            $exists = DB::table('professeur_matiere')
                ->where('professeur_id', $request->professeur_id)
                ->where('matiere_id', $request->matiere_id)
                ->where('classe_id', $request->classe_id)
                ->exists();

            if ($exists) {
                return redirect()->back()->with('error', 'Cette assignation existe déjà.');
            }

            // Ajouter l'assignation
            DB::table('professeur_matiere')->insert([
                'professeur_id' => $request->professeur_id,
                'matiere_id' => $request->matiere_id,
                'classe_id' => $request->classe_id,
                'nb_heures' => $request->nb_heures,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Matière assignée avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l’assignation : ' . $e->getMessage());
        }
    }

    public function updateAssignment(Request $request)
    {
        $request->validate([
            'professeur_id' => 'required|exists:professeurs,id',
            'matiere_id' => 'required|exists:matieres,id',
            'classe_id' => 'required|exists:classes,id',
            'nb_heures' => 'required|integer|min:1',
        ]);

        try {
            DB::table('professeur_matiere')
                ->where('professeur_id', $request->professeur_id)
                ->where('matiere_id', $request->matiere_id)
                ->where('classe_id', $request->classe_id)
                ->update(['nb_heures' => $request->nb_heures, 'updated_at' => now()]);

            return redirect()->back()->with('success', 'Heures mises à jour avec succès !');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }
}
