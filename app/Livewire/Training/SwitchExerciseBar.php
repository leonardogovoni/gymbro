<?php

namespace App\Livewire\Training;

use Livewire\Component;

class SwitchExerciseBar extends Component
{
	public $workout_plan;
	public $day;
	public $current_index;
	public $max_index;

	// Eseguito solo al caricamento del componente
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->current_index = 0;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('order')-1;
	}

	// Eseguito ogni qualvolta una variabile subisce una modifica al suo valore
	public function render()
	{
		return view('livewire.training.switch-exercise-bar', [
			'current_index' => $this->current_index,
			'max_index' => $this->max_index
		]);
	}

	public function previous()
	{
		$this->current_index > 0 ? $this->dispatch('change-index', --$this->current_index) : null;
	}

	public function next()
	{
		$this->current_index < $this->max_index ? $this->dispatch('change-index', ++$this->current_index) : null;
	}
}
