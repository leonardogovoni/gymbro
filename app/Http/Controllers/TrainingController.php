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
	
		return view('training_pages.training', [
			'workout_plan_enabled' => $exercises,
			'exercises_by_day' => $exercises_by_day,
			'workout_plan_title' => $workout_plan_title,
		]);
    }

	public function inspect($day, Request $request)
    {
		// Recupera la scheda del database 'attiva'
		$workout_plan_enabled = $request->user()->workout_plans()->where('enabled', true)->first();

        // Recupera gli esercizi per il giorno selezionato
        $exercises = WorkoutPlan::find($workout_plan_enabled->id)
            ->exercises()
            ->where('day', $day)
            ->orderBy('sequence')
            ->get();

        // Puoi passare gli esercizi o altre informazioni alla vista
        return view('training_pages.inspect_training', [
            'day' => $day,
            'exercises' => $exercises
        ]);
    }
}
