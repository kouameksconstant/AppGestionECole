<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController; // Assurez-vous que le contrôleur existe

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('students', StudentController::class);

// Route pour gérer une classe spécifique
Route::get('/class/manage/{class}', [ClassController::class, 'manage'])->name('class.manage');

// Route pour créer une nouvelle classe
Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');

// Route pour enregistrer une nouvelle classe (store)
Route::post('/classes/store', [ClassController::class, 'store'])->name('classes.store');

// Route pour assigner une classe à un étudiant
Route::get('/students/assign-class', [StudentController::class, 'assignClass'])->name('students.assign_class');
// Route pour afficher le formulaire d'assignation

// Route pour traiter l'assignation de la classe à l'étudiant
Route::post('/students/assign-class', [StudentController::class, 'storeAssignedClass'])->name('students.store_assign_class');
