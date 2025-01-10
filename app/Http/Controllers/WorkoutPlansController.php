<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class WorkoutPlansController extends Controller
{
	// Metodo per visualizzare la pagina e recuperare le schede
	public function index(Request $request)
	{
		// Recupera tutte le schede dal database
		$workout_plans = $request->user()->workout_plans;

		// Passa i dati alla vista
		return view('workout_plans.list', [
			'workout_plans' => $workout_plans
		]);
    }

	// Metodo per gestire i dati inviati dal form
	public function store(Request $request)
	{
		// Validazione dei dati
		$validatedData = $request->validate([
			'data1' => 'required|string|max:255',
			'data2' => 'required|string|max:255',
			'data3' => 'required|date',
			'data4' => 'required|date',
		]);

		// Inserimento dei dati nel database
        WorkoutPlan::create([
			// L'utente e' sempre loggato, quindi l'ID deve esistere
			'user_id' => auth()->id(),

			// Valori inseriti nel form
			'title' => $validatedData['data1'],
			'description' => $validatedData['data2'],
			'start' => $validatedData['data3'],
			'end' => $validatedData['data4'],

			// default: false
			'enabled' => false
		]);

		return redirect()->route('workout_plans.list');
	}

	public function edit($id, Request $request)
	{
		$workout_plan = $request->user()->workout_plans()->where('id', $id)->firstOrFail();

		return view('workout_plans.edit', [
			'workout_plan' => $workout_plan,
			'workout_plan_id' => $id
		]);
	}

	public function delete(Request $request)
	{
		$id = $request->input('id');

		// Trova la scheda da eliminare in base all'ID ricevuto
        $workoutPlan = WorkoutPlan::findOrFail($id);
        
        // Elimina la scheda
        $workoutPlan->delete();

        // Reindirizza alla stessa view con un messaggio di successo
        return redirect()->route('workout_plans.list');
	}
}
