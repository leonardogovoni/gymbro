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

    public function inspect($exercise, Request $request)
    {
        $selectedExercise = Exercise::find($exercise);

        // Recupera i dati dell'esercizio filtrando per exercise_id
        $exerciseData = ExerciseData::where('exercise_id', $exercise)
            ->where('user_id', auth()->id()) // Filtro per l'utente loggato
            ->orderBy('created_at', 'asc')
            ->get();

        // Passa i dati al view come JSON
        return view('statistics.exercise_stats', [
            'selectedExercise' => $selectedExercise,
            'exerciseData' => $exerciseData
        ]);
    }
}
