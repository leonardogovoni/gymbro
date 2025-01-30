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

	// Variabili di controllo per permessi
	public $is_admin;
	public $is_gym;
	public $gym_id;

	// Parametri GET
	#[Url]
	public $user_id;

	// Variabili di controllo
	public $search_parameter;

	// Eseguito a ogni modifica di una variabile
	public function render()
	{
		if (!$this->user_id)
			// Non è selezionato un utente, mostro la lista di quelli che hanno esercizi
			// registrati; se non è admin mostro solo i clienti della palestra
			$results = User::select('id', 'first_name', 'last_name', 'controlled_by')
				->where(function ($query) {
					$query->where('first_name', 'like', "%{$this->search_parameter}%")
						->orWhere('last_name', 'like', "%{$this->search_parameter}%");
				})
				->when(!$this->is_admin && $this->is_gym, function ($query) {
					$query->where('controlled_by', '=', $this->gym_id);
				})
				->withCount('exercises_data as recorded_sets')
				->withCount(['exercises_data as recorded_exercises' => function ($query) {
					$query->select(DB::raw('count(distinct exercise_id)'));
				}])
				->having('recorded_sets', '>', 0)
				->paginate(20);
		elseif ($this->user_id) {
			// Se sono palestra, controllo che l'utente sia mio cliente
			if (!$this->is_admin && $this->is_gym)
				Auth::user()->gym_clients()->where('id', $this->user_id)->first() == null ? redirect()->route('admin.progress') : null;

			// E' selezionato un utente, mostro gli esercizi registrati
			$results = ExerciseData::join('exercises', 'exercises_data.exercise_id', '=', 'exercises.id')
				->select('exercise_id', 'exercises.name', DB::raw('count(exercise_id) as recorded_sets'))
				->where('exercises.name', 'like', "%{$this->search_parameter}%")
				->where('user_id', $this->user_id)
				->groupBy('exercise_id', 'exercises.name')
				->paginate();
		}

		return view('livewire.crud.progress', [
			'results' => $results
		]);
	}

	// Eseguito solo al mount
	public function mount()
	{
		// Controllo permessi
		$user = Auth::user();
		$this->is_admin = $user->is_admin;
		$this->is_gym = $user->is_gym;
		$this->gym_id = $user->id;
	}

	public function selectUser($id)
	{
		$this->user_id = $id;
		$this->search_parameter = null;
	}

	// Usare il tag a dava problemi
	public function selectExercise($id)
	{
		$this->redirectRoute('admin.progress-chart', [
			'user_id' => $this->user_id,
			'exercise_id' => $id
		]);
	}

	public function restart()
	{
		$this->user_id = null;
	}
}
