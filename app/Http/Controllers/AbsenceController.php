<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Professeur;
use Illuminate\Support\Facades\DB;

class AbsenceController extends Controller
{
    // Affiche le formulaire de création d'une absence
    public function create()
    {
        $professeurs = Professeur::all();
        return view('absences.create', compact('professeurs'));
    }

    // Enregistre une nouvelle absence
    public function store(Request $request)
    {
        $request->validate([
            'professeur_id' => 'required|exists:professeurs,id',
            'matiere_id'    => 'required|exists:matieres,id',
            'classe_id'     => 'required|exists:classes,id',
            'date_absence'  => 'required|date',
            'duree'         => 'required|integer|min:1',
            'motif'         => 'nullable|string',
        ]);

        Absence::create([
            'professeur_id' => $request->professeur_id,
            'matiere_id'    => $request->matiere_id,
            'classe_id'     => $request->classe_id,
            'date_absence'  => $request->date_absence,
            'duree'         => $request->duree,
            'motif'         => $request->motif,
            'statut'        => 'en attente',
        ]);

        return redirect()->back()->with('success', 'Absence déclarée avec succès !');
    }

    // Affiche la liste paginée des absences agrégées par professeur, matière et classe
    public function index()
    {
        $absences = Absence::select(
                'professeur_id',
                'matiere_id',
                'classe_id',
                DB::raw('SUM(duree) as total_duree'),
                DB::raw('MIN(date_absence) as first_absence_date')
            )
            ->groupBy('professeur_id', 'matiere_id', 'classe_id')
            ->with(['professeur', 'matiere', 'classe'])
            ->paginate(10);

        return view('absences.index', compact('absences'));
    }

    // Affiche la liste paginée des absences détaillées pour un groupe spécifique
    public function detail($professeur, $matiere, $classe)
    {
        $absences = Absence::with(['professeur', 'matiere', 'classe'])
            ->where('professeur_id', $professeur)
            ->where('matiere_id', $matiere)
            ->where('classe_id', $classe)
            ->paginate(10);

        return view('absences.detail', compact('absences'));
    }
}
