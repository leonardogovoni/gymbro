<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanExercise;

class TrainingController extends Controller
{
	// Metodo per visualizzare la pagina e recuperare le schede
	public function index(Request $request)
	{
		// Recupera la scheda del database 'attiva'
		$workout_plan_enabled = $request->user()->workout_plans()->where('enabled', true)->first();

		// Se non esiste una scheda attiva, restituisci una vista con un messaggio appropriato
		if (!$workout_plan_enabled) {
			return view('training_pages.training', [
				'workout_plan_enabled' => null,
				'exercises_by_day' => collect(),
				'workout_plan_title' => 'Nessuna scheda attiva',
				'selected_day' => null,
				'selected_exercises' => collect()
			]);
		}
	
		// Recupera il titolo della scheda attiva
		$workout_plan_title = $workout_plan_enabled->title;
	
		// Recupera tutti gli esercizi ordinati
		$exercises = WorkoutPlan::find($workout_plan_enabled->id)
			->exercises()
			->orderBy('day')
			->orderBy('sequence')
			->get(['day', 'name', 'sequence']);
	
		// Organizza gli esercizi per giorno
		$exercises_by_day = $exercises->groupBy('day');
	
		// Giorno selezionato, predefinito a 1 se non specificato
		$selected_day = $request->get('day_', 1);
	
		// Filtra gli esercizi per il giorno selezionato
		$selected_exercises = $exercises_by_day[$selected_day] ?? collect();
	
		return view('training_pages.training', [
			'workout_plan_enabled' => $exercises,
			'exercises_by_day' => $exercises_by_day,
			'workout_plan_title' => $workout_plan_title,
			'selected_day' => $selected_day,
			'selected_exercises' => $selected_exercises
		]);
	}

	public function inspect($day, Request $request)
	{
		$workout_plan_enabled = $request->user()->workout_plans()->where('enabled', true)->first();

		// Recupera il titolo della scheda attiva
		$workout_plan_title = $workout_plan_enabled->title;

		$exercises = WorkoutPlan::find($workout_plan_enabled->id)
			->exercises()
			->where('day', $day)
			->orderBy('sequence')
			->get();

		// Imposta l'esercizio corrente
		$currentIndex = $request->input('exercise', 0);

		return view('training_pages.inspect_training', [
			'workout_plan_title' => $workout_plan_title,
			'day' => $day,
			'exercises' => $exercises,
			'currentIndex' => $currentIndex,
		]);
	}
}
