<?php

namespace App\Livewire\Training;

use Livewire\Component;

class SwitchExerciseBar extends Component
{
	public $workout_plan;
	public $day;
	public $current_index;
	public $max_index;

	// Executed only when component is created
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->current_index = 0;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('order')-1;
	}

	// Executed everytime a variable gets updated
	public function render()
	{
		return view('livewire.training.switch-exercise-bar', [
			'current_index' => $this->current_index,
			'max_index' => $this->max_index
		]);
	}

	public function previous()
	{
		if($this->current_index > 0) {
			$this->current_index--;
			$this->dispatch('change-index', $this->current_index);
		}
	}

	public function next()
	{
		if($this->current_index < $this->max_index) {
			$this->current_index++;
			$this->dispatch('change-index', $this->current_index);
		}
	}
}
