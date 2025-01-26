<?php

namespace App\Livewire\Statistics;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Exercise;

class ExercisesList extends Component
{
	public $results;
	public $categories;
	public $search_parameter;
	public $category_parameter;

	// Eseguito quando si carica il componente
	public function mount()
	{
		$this->categories = Exercise::orderBy('muscle')->distinct()->pluck('muscle');
	}

	// Eseguito quando cambia il parametro di ricerca
	public function render()
	{
		// Recupera SOLO gli esercizi che l'utente ha svolto
		$this->results = Exercise::whereIn('id', function($query) {
				$query->select('exercise_id')
					->from('exercises_data')
					->where('user_id', auth()->id())
					->distinct();
			})
			->where('name', 'like', '%'.$this->search_parameter.'%')
			->when($this->category_parameter && $this->category_parameter != 'all', function ($query) {
				$query->where('muscle', '=', $this->categories[$this->category_parameter]);
			})
			->get();

		return view('livewire.statistics.exercises-list');
	}
}
