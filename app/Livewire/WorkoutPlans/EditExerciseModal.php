<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;
use Livewire\Attributes\On; 

class EditExerciseModal extends Component
{
	public $workout_plan;
	public $pivot_id;

	public $rest;
	public $sets;
	public $maximal;
	public $same_reps;
	public $reps = [];

    // Executed everytime a variable gets updated
    public function render()
    {
		return view('livewire.workout_plans.edit-exercise-modal');
    }

    // Recieves data from the edit button component
    #[On('edit')]
    public function open($pivot_id)
    {
		$this->pivot_id = $pivot_id;
		$exercise_data = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();
		// dump($exercise_data->pivot['rest']);
		$this->rest = str($exercise_data->pivot['rest']);
		$this->sets = $exercise_data->pivot['sets'];
		$this->same_reps = !str_contains($exercise_data->pivot['reps'], '-');
		$this->reps = explode('-', $exercise_data->pivot['reps']);
		
		if ($this->reps[0] == 'MAX')
			$this->maximal = true;

        $this->dispatch('open-modal', 'edit');
    }

	public function save()
	{
		$reps_str = $this->maximal ? 'MAX' : ($this->same_reps ? $this->reps[0] : implode('-', $this->reps));

		$this->workout_plan->exercises()->wherePivot('id', $this->pivot_id)->update([
			'rest' => $this->rest,
			'sets' => $this->sets,
			'reps' => $reps_str,
			'edited' => true
		]);
        $this->dispatch('exercise-updated');
        $this->dispatch('close-modal', 'edit');
	}
}
