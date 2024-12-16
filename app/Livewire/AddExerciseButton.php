<?php

namespace App\Livewire;

use Livewire\Component;

class AddExerciseButton extends Component
{
    public $day;

    public function render()
    {
        return view('livewire.add-exercise-button');
    }

	public function add()
	{
        $this->dispatch('add-modal', day: $this->day);
	}
}
