<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkoutPlansController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Pagina 'allenamento', per ora placeholder
Route::get('/training', function () {
    return view('training');
})->middleware(['auth', 'verified'])->name('training');

Route::get('/training/edit', function () {
    return view('training/edit');
})->middleware(['auth', 'verified'])->name('training.edit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workout_plans', [WorkoutPlansController::class, 'index'])->name('workout_plans.list');
    Route::post('/workout_plans', [WorkoutPlansController::class, 'store'])->name('workout_plans.create');
    Route::post('/workout_plans/edit', [WorkoutPlansController::class, 'edit'])->name('workout_plans.edit');
	Route::delete('/workout_plans/delete', [WorkoutPlansController::class, 'delete'])->name('workout_plans.delete');
});

require __DIR__.'/auth.php';
