<?php

use App\Http\Controllers\CrudController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\WorkoutPlansController;
use App\Http\Middleware\Admin;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('welcome');
});

Route::middleware('auth')->group(function () {
	// Profilo utente
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	
	// Pagina di visualizzazione delle schede
	Route::get('/workout_plans', [WorkoutPlansController::class, 'index'])->name('workout_plans.list');
	Route::post('/workout_plans', [WorkoutPlansController::class, 'create'])->name('workout_plans.create');
	Route::get('/workout_plans/edit/{id}', [WorkoutPlansController::class, 'edit'])->name('workout_plans.edit');
	
	// Pagina 'allenamento'
	Route::get('/training', [TrainingController::class, 'index'])->name('training');
	Route::get('/training/inspect/{workout_plan_id}/{day}', [TrainingController::class, 'inspect'])->name('training.inspect');

	// Pagina statistiche
	Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.list');
	Route::get('/statistics/{exercise_id}', [StatisticsController::class, 'view'])->name('statistics.view');

	// Pagine CRUD
	Route::middleware([Admin::class])->group(function () {
		Route::get('/admin/users', [CrudController::class, 'users'])->name('admin.users');
		Route::get('/admin/workout_plans', [CrudController::class, 'workout_plans'])->name('admin.workout_plans');
		Route::get('/admin/progress', [CrudController::class, 'progress'])->name('admin.progress');
		Route::get('/admin/progress/chart', [CrudController::class, 'progressChart'])->name('admin.progress_chart');
		Route::get('/admin/exercises', [CrudController::class, 'exercises'])->name('admin.exercises');
	});
});

require __DIR__.'/auth.php';
