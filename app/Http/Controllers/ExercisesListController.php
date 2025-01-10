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

        // Recupera i dati dell'esercizio per l'utente autenticato
        $exerciseData = ExerciseData::where('exercise_id', $exercise)
            ->where('user_id', $request->user()->id)
            ->orderBy('date')
            ->get();

        // Prepara i dati per il grafico (data per l'asse X e Y)
        $chartData = $exerciseData->map(function ($data) {
            return [
                'date' => $data->date,
                'used_kg' => $data->used_kg,
            ];
        });

        // Passa i dati alla vista
        return view('statistics.exercise_stats', compact('selectedExercise', 'chartData'));
    }
}
