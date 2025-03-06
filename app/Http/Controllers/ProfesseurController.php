<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professeur;
use App\Models\Absence;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF; // Si tu veux générer un PDF, assure-toi que le package DomPDF est installé

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

    // Méthode pour générer la fiche de paie d'un professeur
    public function generatePayslip($id)
    {
        $professeur = Professeur::findOrFail($id);

        // Données pour la fiche de paie
        $payslipData = [
            'nom' => $professeur->nom,
            'prenom' => $professeur->prenom,
            'email' => $professeur->email,
            'montant' => $this->calculateSalary($professeur),
            'date' => now()->format('d/m/Y'),
        ];

        // Générer le PDF (si tu veux générer un PDF)
        $pdf = PDF::loadView('professeurs.payslip', compact('payslipData'));

        // Retourner le PDF en téléchargement
        return $pdf->download('payslip_' . $professeur->prenom . '_' . $professeur->nom . '.pdf');

        // Si tu veux juste afficher la fiche de paie sous forme de vue HTML :
        // return view('professeurs.payslip', compact('payslipData'));
    }

    // Méthode pour calculer le salaire d'un professeur (à personnaliser selon tes besoins)
    private function calculateSalary($professeur)
    {
        // Exemple basique de calcul : un salaire fixe pour l'exemple
        // Tu devras ajuster cela en fonction des absences, des heures de travail, etc.
        return 1000; // Exemple d'un salaire fixe de 1000 €
    }
}
