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
		$workout_plan = $request->user()->workout_plans()->where('enabled', true)->first();
		$grouped_exercises = null;

		// Esegue l'operazione solo se $workout_plan e' definito e non null (Elvis)
		// previene alcuni errori dopo l'eliminazione della scheda di default
		if ($workout_plan ?: false) {
			$grouped_exercises = $workout_plan->exercises()
				->orderBy('day')
				->orderBy('sequence')
				->get(['day', 'name', 'sequence'])
				->groupBy('day');
		}

		return view('training.training', [
			'workout_plan' => $workout_plan,
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
