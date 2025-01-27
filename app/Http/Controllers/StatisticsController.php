<?php

namespace App\Http\Controllers;

use App\Models\Exercise;

use Illuminate\Http\Request;

class StatisticsController extends Controller
{
	// Mostra la lista degli esercizi SVOLTI, non tutti
	public function index()
	{
		return view('statistics.list');
	}

	// Mostra le statistiche di un esercizio
	public function view($exercise_id, Request $request)
	{
		// Il return della view avviene solo se $exercise non e' null.
		// Se l'ID e' null, allora restituisce l'elenco degli esercizi.
		$exercise = Exercise::find($exercise_id);
		return $exercise == null
			? redirect()->route('statistics.list')
			: view('statistics.view-exercise', [
				'exercise_id' => $exercise_id,
				'exercise_name' => $exercise->name
			]);
	}
}
