<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::resource('students', StudentController::class);
