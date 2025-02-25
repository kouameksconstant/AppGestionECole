<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\HeureController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\CahierTexteController;
use App\Http\Controllers\AttributionController; // Manquait dans ton code

// 📌 Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// 📌 Routes de gestion des étudiants
Route::resource('students', StudentController::class)->except(['show', 'update']);
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

// 📌 Routes pour la gestion des classes
Route::resource('classes', ClassController::class);

// 📌 Routes pour l'assignation des classes aux étudiants
Route::get('/classes/assign-class', [StudentController::class, 'assignClass'])->name('students.assign_class');
Route::post('/classes/assign-class', [StudentController::class, 'storeAssignedClass'])->name('students.store_assign_class');

// 📌 Route pour la page d'accueil
Route::get('/up', function() {
    return view('welcome');
});

// 📌 Routes pour les professeurs
Route::resource('professeurs', ProfesseurController::class);

// 📌 Routes spécifiques aux professeurs (groupées par préfixe)
Route::prefix('professeurs/{professeur}')->group(function() {
    // Gestion des absences
    Route::resource('absences', AbsenceController::class)->except(['create', 'store']);
    Route::get('absences/create', [AbsenceController::class, 'create'])->name('absences.create');
    Route::post('absences', [AbsenceController::class, 'store'])->name('absences.store');

    // Gestion des heures
    Route::resource('heures', HeureController::class)->except(['create', 'store']);
    Route::get('heures/create', [HeureController::class, 'create'])->name('heures.create');
    Route::post('heures', [HeureController::class, 'store'])->name('heures.store');

    // Assignation des matières aux professeurs
    Route::get('assigner-matieres', [MatiereController::class, 'assign'])->name('matieres.assign');
});

// 📌 Routes pour l'assignation des matières aux professeurs
Route::get('/matieres/assign-matiere', [MatiereController::class, 'assign'])->name('matieres.assign');
Route::post('/matieres/assign-matiere', [MatiereController::class, 'saveAssignment'])->name('matieres.assign.save');
Route::post('/matieres/assign/update', [MatiereController::class, 'updateAssignment'])->name('matieres.assign.update');

// 📌 Routes pour les cahiers de texte et absences
Route::post('/professeur/{id}/absence', [ProfesseurController::class, 'marquerAbsence'])->name('professeur.absence');
Route::post('/cahier-texte/save', [CahierTexteController::class, 'save'])->name('cahier.texte.save');
Route::get('/cahier-texte/{id}', [CahierTexteController::class, 'view'])->name('cahier.texte.view');

// 📌 Route pour l'attribution des matières aux professeurs
Route::get('/attribution/edit/{id}', [AttributionController::class, 'edit'])->name('attribution.edit');
Route::get('/cahier-texte/{id}', [CahierTexteController::class, 'view'])->name('cahier.texte.view');
Route::get('/cahier-texte/{id}', [CahierTexteController::class, 'view'])->name('cahier.texte.view');
