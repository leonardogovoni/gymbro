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
        $exercise = Exercise::find($exercise_id);
        if($exercise == null)
            return redirect()->route('statistics.list');

        return view('statistics.view-exercise', [
            'exercise_id' => $exercise_id,
            'exercise_name' => $exercise->name
        ]);
    }
}
