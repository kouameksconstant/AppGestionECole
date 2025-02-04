<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController; // Assurez-vous que le contrôleur existe
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::resource('students', StudentController::class);


Route::get('/class/manage/{class}', [ClassController::class, 'manage'])->name('class.manage');
