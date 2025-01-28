<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WorkoutPlansController extends Controller
{
	public function index(Request $request)
	{
		$workout_plans_count = $request->user()->workout_plans->count();

		return view('workout_plans.list', [
			'workout_plans_count' => $workout_plans_count
		]);
	}

	// Metodo per gestire i dati inviati dal form
	public function create(Request $request)
	{
		try {
			// Validazione dei dati
			$validated_data = $request->validate([
				'name' => 'required|string|max:100',
				'description' => 'nullable|string|max:400',
			]);

			// Recupera tutte le schede dal database
			$workout_plans = $request->user()->workout_plans->count();

			// Inserimento dei dati nel database
			WorkoutPlan::create([
				// L'utente e' sempre loggato, quindi l'ID deve esistere
				'user_id' => auth()->id(),

				// Valori inseriti nel form
				'title' => $validated_data['name'],
				'description' => $validated_data['description'],

				// default: false, true se e' l'unica scheda creata
				'enabled' => $workout_plans === 0 ? true : false
			]);

			return redirect()->back();
		}
		catch (\Illuminate\Validation\ValidationException $e) {
			return redirect()->back()->with('error', 'Si è verificato un errore durante l\'inserimento della scheda, per favore riprovare.');
		}
	}

	public function edit($id, Request $request)
	{
		return view('workout_plans.edit', [
			'workout_plan' => $request->user()->workout_plans()->where('id', $id)->firstOrFail()
		]);
	}
}
