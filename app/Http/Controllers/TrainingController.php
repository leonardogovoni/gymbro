<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkoutPlan;

class TrainingController extends Controller
{
    // Metodo per visualizzare la pagina e recuperare le schede
	public function index(Request $request)
	{
		// Recupera la scheda del database 'attiva'
		$workout_plan_enabled = $request->user()->workout_plans()->where('enabled', true)->first();
		
		// Restituisce gli esercizi
		$exercises = WorkoutPlan::find($workout_plan_enabled->id)->exercises()->orderBy('sequence')->get();

		return view('training', [
			'workout_plan_enabled' => $exercises
		]);
    }
}
