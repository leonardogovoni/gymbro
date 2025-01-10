<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; 

use App\Models\Exercise;
use App\Models\WorkoutPlan;

class EditExerciseModal extends Component
{
	public $workout_plan_id;
	public $pivot_id;

	public $exercise_data = NULL;

	public $rest;
	public $sets;
	public $maximal;
	public $same_reps;
	public $reps = [];

    // Executed only when component is created
    public function render()
    {
		return view('livewire.edit-exercise-modal');
    }

    // Recieves data from the edit button component
    #[On('edit')]
    public function open($pivot_id)
    {
		$this->pivot_id = $pivot_id;
		$this->exercise_data = WorkoutPlan::find($this->workout_plan_id)->exercises()->wherePivot('id', $pivot_id)->first();

		$this->rest = $this->exercise_data->pivot['rest'];
		$this->sets = $this->exercise_data->pivot['series'];
		$this->same_reps = !str_contains($this->exercise_data->pivot['repetitions'], '-');
		$this->reps = explode('-', $this->exercise_data->pivot['repetitions']);

        $this->dispatch('open-modal', 'edit');
    }

	public function save()
	{
		$reps_str = $this->maximal ? 'MAX' : ($this->same_reps ? $this->reps[0] : implode('-', $this->reps));
		
		WorkoutPlan::find($this->workout_plan_id)->exercises()->wherePivot('id', $this->pivot_id)->update([
			'rest' => $this->rest,
			'series' => $this->sets,
			'repetitions' => $reps_str
		]);
        $this->dispatch('exercise-updated');
        $this->dispatch('close-modal', 'edit');
	}
}
