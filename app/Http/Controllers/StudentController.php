<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classe; // Ajout de la classe Classe pour les relations
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class StudentController extends Controller
{
    /**
     * Affiche la liste des étudiants avec pagination et filtrage par classe.
     */
    public function index(Request $request)
    {
        $class = $request->query('class'); // Récupère la classe sélectionnée

        // Récupère les étudiants selon la classe sélectionnée avec pagination
        $students = Student::with('classe') // Charge la relation classe
            ->when($class, function ($query) use ($class) {
                $query->whereHas('classe', function ($subQuery) use ($class) {
                    $subQuery->where('name', $class);
                });
            })
            ->paginate(10);

        return view('adminlte.students.index', compact('students', 'class'));
    }

    /**
     * Affiche le formulaire de création d'un étudiant.
     */
    public function create()
    {
        $classes = Classe::all(); // Récupérer toutes les classes pour le formulaire
        return view('adminlte.students.create', compact('classes'));
    }

    /**
     * Enregistre un étudiant dans la base de données.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'tel_perso' => 'nullable|regex:/^[0-9]{10}$/',
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'classe_id' => 'nullable|exists:classes,id' // Vérifie que la classe existe
        ]);

        try {
            // Création de l'étudiant
            Student::create($validated);
            return redirect()->route('students.index')->with('success', 'Étudiant ajouté avec succès.');
        } catch (QueryException $e) {
            return back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement.');
        }
    }

    /**
     * Affiche un étudiant spécifique.
     */
    public function show(Student $student)
    {
        return view('adminlte.students.show', compact('student'));
    }

    /**
     * Affiche le formulaire de modification d'un étudiant.
     */
    public function edit(Student $student)
    {
        $classes = Classe::all();
        return view('adminlte.students.edit', compact('student', 'classes'));
    }

    /**
     * Met à jour un étudiant dans la base de données.
     */
    public function update(Request $request, Student $student)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'tel_perso' => 'nullable|regex:/^[0-9]{10}$/',
            'birth_date' => 'required|date',
            'lieu_naissance' => 'required|string|max:255',
            'classe_id' => 'nullable|exists:classes,id'
        ]);

        try {
            $student->update($validated);
            return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
        } catch (QueryException $e) {
            return back()->with('error', 'Une erreur s\'est produite lors de la mise à jour.');
        }
    }

    /**
     * Supprime un étudiant de la base de données.
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
        } catch (QueryException $e) {
            return back()->with('error', 'Impossible de supprimer cet étudiant.');
        }
    }
    public function assignClass()
{
    // Récupérer toutes les classes disponibles
    $classes = Classe::all(); 

    // Récupérer tous les étudiants non encore assignés à une classe
    $students = Student::whereNull('classe_id')->get();

    // Retourner la vue avec les étudiants et les classes
    return view('adminlte.students.assign-class', compact('students', 'classes'));
}
public function storeAssignedClass(Request $request)
{
    // Validation des données du formulaire
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',  // L'étudiant doit exister
        'classe_id' => 'required|exists:classes,id',   // La classe doit exister
    ]);

    // Trouver l'étudiant et lui assigner la classe
    $student = Student::find($validated['student_id']);
    $student->classe_id = $validated['classe_id'];
    $student->save();  // Sauvegarder l'étudiant avec la nouvelle classe

    // Rediriger vers la liste des étudiants avec un message de succès
    return redirect()->route('students.index')->with('success', 'L\'étudiant a été assigné à une classe avec succès!');
}

}
