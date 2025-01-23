<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index()
    {
        return view('crud.dashboard');
    }

    public function users()
    {
        return view('crud.users');
    }

    public function workout_plans()
    {
        return view('crud.workout_plans');
    }

    // public function inspect($exercise, Request $request)
    // {
    //     $selectedExercise = Exercise::find($exercise);

    //     // Recupera i dati dell'esercizio filtrando per exercise_id
    //     $exerciseData = ExerciseData::where('exercise_id', $exercise)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     // Passa i dati al view come JSON
    //     return view('statistics.exercise_stats', [
    //         'selectedExercise' => $selectedExercise,
    //         'exerciseData' => $exerciseData
    //     ]);
    // }
}
