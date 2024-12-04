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
		$schede = $request->user()->workout_plans;

		// Passa i dati alla vista
		return view('schede', [
			'schede' => $schede
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

		return redirect()->route('schede');
	}

	public function editor()
	{

	}
}
