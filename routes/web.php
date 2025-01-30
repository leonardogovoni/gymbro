<?php

use App\Http\Controllers\CrudController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkoutPlansController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Gym;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::middleware('auth')->group(function () {
	// Middleware per bloccare l'accesso alla app alle palestre
	Route::middleware([Gym::class])->group(function () {
		// Profilo utente
		Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
		Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
		Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
		
		// Pagina di visualizzazione delle schede
		Route::get('/workout-plans', [WorkoutPlansController::class, 'index'])->name('workout-plans.list');
		Route::post('/workout-plans', [WorkoutPlansController::class, 'create'])->name('workout-plans.create');
		Route::get('/workout-plans/edit/{id}', [WorkoutPlansController::class, 'edit'])->name('workout-plans.edit');
		
		// Pagina 'allenamento'
		Route::get('/training', [TrainingController::class, 'index'])->name('training.select-day');
		Route::get('/training/inspect/{workout_plan_id}/{day}', [TrainingController::class, 'inspect'])->name('training.inspect');

		// Pagina statistiche
		Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.list');
		Route::get('/statistics/{exercise_id}', [StatisticsController::class, 'view'])->name('statistics.view');
	});

	// Pagine CRUD solo per palestre e admin
	Route::middleware([Admin::class])->group(function () {
		Route::get('/admin/users', [CrudController::class, 'users'])->name('admin.users');
		Route::get('/admin/workout-plans', [CrudController::class, 'workoutPlans'])->name('admin.workout-plans');
		Route::get('/admin/progress', [CrudController::class, 'progress'])->name('admin.progress');
		Route::get('/admin/progress/chart', [CrudController::class, 'progressChart'])->name('admin.progress-chart');
		Route::get('/admin/exercises', [CrudController::class, 'exercises'])->name('admin.exercises');
	});
});

require __DIR__.'/auth.php';
