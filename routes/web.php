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
use App\Http\Controllers\AttributionController;

// Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes de gestion des étudiants
Route::resource('students', StudentController::class)->except(['show', 'update']);
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

// Routes pour la gestion des classes
Route::resource('classes', ClassController::class);

// Routes pour l'assignation des classes aux étudiants
Route::get('/classes/assign-class', [StudentController::class, 'assignClass'])->name('students.assign_class');
Route::post('/classes/assign-class', [StudentController::class, 'storeAssignedClass'])->name('students.store_assign_class');

// Route pour la page d'accueil
Route::get('/up', function() {
    return view('welcome');
});

// Routes pour les professeurs
Route::resource('professeurs', ProfesseurController::class);

// Routes spécifiques aux professeurs
Route::prefix('professeurs/{professeur}')->group(function() {
    Route::resource('absences', AbsenceController::class)->except(['create', 'store']);
    Route::get('absences/create', [AbsenceController::class, 'create'])->name('absences.create');
    Route::post('absences', [AbsenceController::class, 'store'])->name('absences.store');

    Route::resource('heures', HeureController::class)->except(['create', 'store']);
    Route::get('heures/create', [HeureController::class, 'create'])->name('heures.create');
    Route::post('heures', [HeureController::class, 'store'])->name('heures.store');

    Route::get('assigner-matieres', [MatiereController::class, 'assign'])->name('matieres.assign');
});

// Routes pour l'assignation des matières aux professeurs
Route::get('/matieres/assign-matiere', [MatiereController::class, 'assign'])->name('matieres.assign');
Route::post('/matieres/assign-matiere', [MatiereController::class, 'saveAssignment'])->name('matieres.assign.save');
Route::post('/matieres/assign/update', [MatiereController::class, 'updateAssignment'])->name('matieres.assign.update');

// Routes pour les cahiers de texte et absences
Route::post('/professeur/{id}/absence', [ProfesseurController::class, 'marquerAbsence'])->name('professeur.absence');
Route::post('/cahier-texte/save', [CahierTexteController::class, 'save'])->name('cahier.texte.save');
Route::get('/cahier-texte/{professeur_id}', [CahierTexteController::class, 'view'])->name('cahier.texte.view');

// Routes pour les attributions
Route::get('/attribution/edit/{id}', [AttributionController::class, 'edit'])->name('attribution.edit');
// Route pour la suppression d'une attribution en utilisant des identifiants composés
Route::delete('/attribution/{professeur_id}/{matiere_id}/{classe_id}', [AttributionController::class, 'destroy'])->name('attribution.destroy');

// Routes pour les cahiers de texte
Route::get('/cahier/{id}', [CahierTexteController::class, 'show'])->name('cahier.show');
Route::get('/cahier/create', [CahierTexteController::class, 'create'])->name('cahier.create');
Route::get('/cahier/view/{id}', [CahierTexteController::class, 'viewCahier'])->name('cahier.view');
Route::get('/cahier/filtrer', [CahierTexteController::class, 'filtrer'])->name('cahier.filtrer');

// Route pour afficher les détails d'une attribution avec trois paramètres
Route::get('/attribution/{professeur}/{matiere}/{classe}', [AttributionController::class, 'show'])->name('attribution.show');
Route::put('/matieres/assign/update', [MatiereController::class, 'updateAssignment'])->name('matieres.assign.update');
// Routes pour les absences
Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
Route::get('/absences/create', [AbsenceController::class, 'create'])->name('absences.create');
Route::post('/absences', [AbsenceController::class, 'store'])->name('absences.store');
// Vous pouvez ajouter des routes pour l'édition et la suppression si besoin
Route::post('/professeur/{id}/absence', [ProfesseurController::class, 'marquerAbsence'])->name('professeur.absence');
Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');
Route::get('/absences/detail/{professeur}/{matiere}/{classe}', [AbsenceController::class, 'detail'])->name('absences.detail');
Route::post('/professeur/{id}/absence', [ProfesseurController::class, 'marquerAbsence'])->name('professeur.absence');
