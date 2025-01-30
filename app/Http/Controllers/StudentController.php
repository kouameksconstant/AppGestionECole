<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Affiche la liste des étudiants avec pagination.
     */
    public function index()
    {
        $students = Student::paginate(10); // Récupère les étudiants avec pagination (10 par page)
        return view('adminlte.students.index', compact('students')); // Retourne la vue avec les étudiants
    }

    /**
     * Affiche le formulaire de création d'un étudiant.
     */
    public function create()
    {
        return view('adminlte.students.create'); // Retourne la vue pour créer un étudiant
    }

    /**
     * Enregistre un étudiant dans la base de données.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255', // Ajout du prénom
            'email' => 'required|email|unique:students,email',
            'tel_perso' => 'nullable|regex:/^[0-9]{10}$/', // Validation du téléphone
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required|string|max:255', // Ajout du lieu de naissance
        ]);

        // Créer l'étudiant
        Student::create($validated);

        // Redirection avec message de succès
        return redirect()->route('students.index')->with('success', 'Étudiant ajouté avec succès.');
    }

    /**
     * Affiche un étudiant spécifique.
     */
    public function show(Student $student)
    {
        return view('adminlte.students.show', compact('student')); // Retourne la vue pour afficher un étudiant
    }

    /**
     * Affiche le formulaire de modification d'un étudiant.
     */
    public function edit(Student $student)
    {
        return view('adminlte.students.edit', compact('student')); // Retourne la vue pour éditer un étudiant
    }

    /**
     * Met à jour un étudiant dans la base de données.
     */
    public function update(Request $request, Student $student)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255', // Ajout du prénom pour la mise à jour
            'email' => 'required|email|unique:students,email,' . $student->id,
            'tel_perso' => 'nullable|regex:/^[0-9]{10}$/', // Validation du téléphone
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required|string|max:255', // Ajout du lieu de naissance pour la mise à jour
        ]);

        // Mettre à jour l'étudiant
        $student->update($validated);

        // Redirection avec message de succès
        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Supprime un étudiant de la base de données.
     */
    public function destroy(Student $student)
    {
        // Supprimer l'étudiant
        $student->delete();

        // Redirection avec message de succès
        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
