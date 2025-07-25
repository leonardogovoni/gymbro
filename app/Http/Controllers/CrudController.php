<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CrudController extends Controller
{
	public function users()
	{
		return view('crud.users');
	}

	public function workoutPlans()
	{
		return view('crud.workout-plans');
	}

	public function progress()
	{
		return view('crud.progress');
	}

	public function progressChart(Request $request)
	{
		// Se non sono stati passati i parametri user_id e exercise_id
		if ($request->input('user_id') == null || $request->input('exercise_id') == null)
			return redirect()->route('admin.progress');

		// Se è palestra, controllo che l'utente sia cliente di essa
		if (!Auth::user()->is_admin && Auth::user()->is_gym)
			if (Auth::user()->gym_clients()->where('id', $request->input('user_id'))->first() == null)
				return redirect()->route('admin.progress');

		return view('crud.progress-chart', [
			'user_id' => $request->input('user_id'),
			'exercise_id' => $request->input('exercise_id')
		]);
	}

	public function exercises(Request $request)
	{
		// Se è palestra non può accedere a questa pagina
		if (!Auth::user()->is_admin && Auth::user()->is_gym)
			return back();

		return view('crud.exercises');
	}
}
