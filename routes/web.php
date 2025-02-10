<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController; // Assurez-vous que le contrôleur existe

// Route pour le tableau de bord
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes de gestion des étudiants (en excluant les routes 'show' et 'update')
Route::resource('students', StudentController::class)->except(['show', 'update']); 

// Route pour afficher un étudiant spécifique
Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');

// Routes pour la création et l'édition des étudiants
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

// Route pour gérer une classe spécifique
Route::get('/class/manage/{class}', [ClassController::class, 'manage'])->name('class.manage');

// Routes pour la gestion des classes
Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store');
Route::get('/classes/edit/{id}', [ClassController::class, 'edit'])->name('classes.edit');
Route::post('/classes/update/{id}', [ClassController::class, 'update'])->name('classes.update');
Route::delete('/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');

// Routes pour l'assignation des classes aux étudiants
Route::get('/classes/assign-class', [StudentController::class, 'assignClass'])->name('students.assign_class');
Route::post('/classes/assign-class', [StudentController::class, 'storeAssignedClass'])->name('students.store_assign_class');

// Route pour les autres pages nécessaires
Route::get('/up', function() { return view('welcome'); });
// Route pour l'assignation des classes aux étudiants (POST pour stocker l'assignation)
Route::post('/students/assign-class', [StudentController::class, 'storeAssignedClass'])->name('classes.storeAssignedClass');
Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::get('classes/{class}', [ClassController::class, 'show'])->name('classes.show');
Route::get('classes/{class}', [ClassController::class, 'show'])->name('classes.show');

