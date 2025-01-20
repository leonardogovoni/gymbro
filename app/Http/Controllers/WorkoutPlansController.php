<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use Illuminate\Http\Request;

class WorkoutPlansController extends Controller
{
	// Metodo per visualizzare la pagina e recuperare le schede
	public function index(Request $request)
	{
		// Recupera tutte le schede dell'utente dal database
		$workout_plans = $request->user()->workout_plans;

		// Passa i dati alla vista
		return view('workout_plans.list', [
			'workout_plans' => $workout_plans
		]);
    }

	// Metodo per gestire i dati inviati dal form
	public function create(Request $request)
	{
		// Validazione dei dati
		// Caso limite: il controllo dal frontend viene effettuato solo tramite 'required' che verifica esclusivamente la presenza o meno di caratteri,
		// uno spam di spazi/invii bypassa quel check ma non questo, il che significa che la scheda non viene creata e l'utente non riceve notifiche.
		$validatedData = $request->validate([
			'workout_plan_name' => 'required|string|max:100',
			'workout_plan_description' => 'nullable|string|max:400',
			'workout_plan_start_date' => 'required|date',
			'workout_plan_end_date' => 'required|date',
		]);

		// Recupera tutte le schede dal database
		$workout_plans = $request->user()->workout_plans->count();

		// Inserimento dei dati nel database
        WorkoutPlan::create([
			// L'utente e' sempre loggato, quindi l'ID deve esistere
			'user_id' => auth()->id(),

			// Valori inseriti nel form
			'title' => $validatedData['workout_plan_name'],
			'description' => $validatedData['workout_plan_description'],
			'start' => $validatedData['workout_plan_start_date'],
			'end' => $validatedData['workout_plan_end_date'],

			// default: false, true se e' l'unica scheda creata
			'enabled' => $workout_plans == 0 ? true : false
		]);

		return redirect()->route('workout_plans.list');
	}

	public function edit($id, Request $request)
	{
		$workout_plan = $request->user()->workout_plans()->where('id', $id)->firstOrFail();

		return view('workout_plans.edit', [
			'workout_plan' => $workout_plan
		]);
	}

	public function delete(Request $request)
	{
		$id = $request->input('id');

		// Trova la scheda da eliminare in base all'ID ricevuto
        $workoutPlan = WorkoutPlan::findOrFail($id);
        
        // Elimina la scheda
        $workoutPlan->delete();

        // Reindirizza alla stessa view
        return redirect()->route('workout_plans.list');
	}
}
