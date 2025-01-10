<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\ExerciseData;

class ExercisesListController extends Controller
{
    public function index()
    {
        $exercises = Exercise::all(); // Recupera tutti gli esercizi
        return view('statistics.exercises_list', compact('exercises'));
    }

    public function inspect($exercise, Request $request)
    {
        $selectedExercise = Exercise::find($exercise);

        // Recupera i dati dell'esercizio filtrando per exercise_id
        $exerciseData = ExerciseData::where('exercise_id', $exercise)
            ->orderBy('date', 'asc')
            ->get();

        // Passa i dati al view come JSON
        return view('statistics.exercise_stats', [
            'selectedExercise' => $selectedExercise,
            'exerciseData' => $exerciseData
        ]);
    }
}
