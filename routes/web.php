<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExercisesListController;
use App\Http\Controllers\ExerciseStatsSelectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkoutPlansController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
	// Profilo utente
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	
	// Pagina di visualizzazione delle schede
    Route::get('/workout_plans', [WorkoutPlansController::class, 'index'])->name('workout_plans.list');
    Route::post('/workout_plans', [WorkoutPlansController::class, 'store'])->name('workout_plans.create');
    Route::get('/workout_plans/edit/{id}', [WorkoutPlansController::class, 'edit'])->name('workout_plans.edit');
	Route::delete('/workout_plans/delete', [WorkoutPlansController::class, 'delete'])->name('workout_plans.delete');
	
	// Pagina 'allenamento'
	Route::get('/training', [TrainingController::class, 'index'])->name('training');
    Route::get('/training/inspect/{workout_plan_id}/{day}', [TrainingController::class, 'inspect'])->name('training.inspect');

    // Pagina statistiche
    Route::get('/statistics/exercises-list', [ExercisesListController::class, 'index'])->name('exercises-list');
    Route::get('/exercises/{exercise}/stats', [ExercisesListController::class, 'inspect'])->name('exercises-list.exercise-stats');


	Route::get('/training/edit', [TrainingController::class, 'edit'])->name('training.edit');
});

require __DIR__.'/auth.php';
