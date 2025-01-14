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
			return view('training.training', [
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
	
		return view('training.training', [
			'workout_plan_enabled' => $exercises,
			'exercises_by_day' => $exercises_by_day,
			'workout_plan_title' => $workout_plan_title
		]);
	}

	public function inspect($workout_plan_id, $day, Request $request)
	{
		$workout_plan = $request->user()->workout_plans()->where('id', $workout_plan_id)->firstOrFail();

		// // Recupera il titolo della scheda attiva
		// $workout_plan_title = $workout_plan->title;

		// $exercises = $workout_plan->exercises()->where('day', $day)->orderBy('sequence')->get();

		// // Imposta l'esercizio corrente
		// $currentIndex = $request->input('exercise', 0);

		return view('training.inspect', [
			'workout_plan' => $workout_plan,
			'day' => $day
		]);
	}
}
