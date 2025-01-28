<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;
use App\Models\WorkoutPlanExercise;

class TrainingController extends Controller
{
	// Metodo per visualizzare i giorni della sheda di allenamento di default
	public function index(Request $request)
	{
		$workout_plan = $request->user()->workout_plans()->where('enabled', true)->first();
		$grouped_exercises = null;

		// Esiste una scheda dell'utente impostata a enabled,
		// recupero gli esercizi raggruppati per giorno
		if ($workout_plan != null) {
			$grouped_exercises = $workout_plan->exercises()
				->orderBy('day')
				->orderBy('order')
				->get(['day', 'name', 'order'])
				->groupBy('day');
		}

		// Se grouped_exercises è vuoto, allora non ci sono esercizi nella scheda
		return view('training.select-day', [
			'workout_plan_id' => $workout_plan->id ?? null,
			'grouped_exercises' => $grouped_exercises
		]);
	}

	public function inspect($workout_plan_id, $day, Request $request)
	{
		$workout_plan = $request->user()->workout_plans()->where('id', $workout_plan_id)->firstOrFail();

		return view('training.inspect', [
			'workout_plan' => $workout_plan,
			'day' => $day
		]);
	}
}
