namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function index()
    {
        // Afficher tous les étudiants
        $students = Student::all();
        return view('adminlte.students.index', compact('students'));  // Vue à utiliser
    }

    public function create()
    {
        // Formulaire pour créer un étudiant
        return view('adminlte.students.create');  // Vue à utiliser
    }

    public function store(Request $request)
    {
        try {
            // Validation et enregistrement d'un étudiant
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email',
                'birth_date' => 'required|date|date_format:Y-m-d',
            ]);

            // Création de l'étudiant dans la base de données
            Student::create($validated);
            return redirect()->route('students.index')->with('success', 'Étudiant créé avec succès.');
        } catch (ValidationException $e) {
            // Gestion des erreurs de validation
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function show(Student $student)
    {
        // Afficher un étudiant spécifique
        return view('adminlte.students.show', compact('student'));  // Vue à utiliser
    }

    public function edit(Student $student)
    {
        // Formulaire pour éditer un étudiant
        return view('adminlte.students.edit', compact('student'));  // Vue à utiliser
    }

    public function update(Request $request, Student $student)
    {
        try {
            // Validation et mise à jour de l'étudiant
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:students,email,' . $student->id,
                'birth_date' => 'required|date|date_format:Y-m-d',
            ]);

            // Mise à jour de l'étudiant dans la base de données
            $student->update($validated);
            return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
        } catch (ValidationException $e) {
            // Gestion des erreurs de validation
            return back()->withErrors($e->errors())->withInput();
        }
    }

    public function destroy(Student $student)
    {
        try {
            // Supprimer un étudiant
            $student->delete();
            return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
        } catch (\Exception $e) {
            // Gestion des erreurs de suppression
            return redirect()->route('students.index')->with('error', 'Une erreur est survenue lors de la suppression de l\'étudiant.');
        }
    }
}
