<?php

namespace App\Livewire\Crud;

use App\Models\ExerciseData;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;

class ProgressCrud extends Component
{
    use WithPagination;

    // // Parametri GET
    #[Url]
    public $user_id;
    public $exercise_id;

    // // Variabili di controllo
    public $search_parameter;

    // // Eseguito a ogni modifica di una variabile
    public function render()
    {
        if(!$this->user_id)
            // Non è selezionato un utente, mostro la lista di quelli che hanno esercizi registrati
            $results = User::select('id', 'first_name', 'last_name')
                ->where('first_name', 'like', "%{$this->search_parameter}%")
                ->orWhere('last_name', 'like', "%{$this->search_parameter}%")
                ->withCount('exercises_data as recorded_sets')
                ->withCount(['exercises_data as recorded_exercises' => function ($query) {
                    $query->select(DB::raw('count(distinct exercise_id)'));
                }])
                ->having('recorded_sets', '>', 0)
                ->paginate(20);
        elseif($this->user_id)
            // E' selezionato un utente, mostro gli esercizi registrati
            $results = ExerciseData::join('exercises', 'exercises_data.exercise_id', '=', 'exercises.id')
                ->select('exercise_id', 'exercises.name', DB::raw('count(exercise_id) as recorded_sets'))
                ->where('user_id', $this->user_id)
                ->groupBy('exercise_id', 'exercises.name')
                ->paginate();

        return view('livewire.crud.progress', [
            'results' => $results
        ]);
    }

    public function selectUser($id)
    {
        $this->user_id = $id;
    }

    public function selectExercise($id)
    {
        $this->redirectRoute('admin.progress_chart', [
            'user_id' => $this->user_id,
            'exercise_id' => $id
        ]);
    }

    public function restart()
    {
        $this->user_id = null;
    }
}
