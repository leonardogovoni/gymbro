<?php

namespace App\Livewire;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On; 

class WorkoutDayEditor extends Component
{
	public $workout_plan;
	public $day;
	public $exercises;

	// Executed only when component is created
	public function mount()
	{
		$this->reloadExercises();
	}

	//  Executed everytime a variable gets updated
	public function render()
	{
		return view('livewire.workout-day-editor', [
			'day' => $this->day,
			'exercises' => $this->exercises
		]);
	}

	// Executed everytime an exercise gets moved
	public function updateOrder($updated_order)
	{
		// Update DB
		// TODO: Could be done with a single query
		foreach($updated_order as $item)
			DB::table('workout_plan_exercises')->where('id', $item['value'])->update(['sequence' => $item['order']]);

		// Reload component exercises
		$this->reloadExercises();
	}

	#[On('exercise-updated')]
	public function reloadExercises()
	{
		$this->exercises = $this->workout_plan->exercises()->where('day', $this->day)->orderBy('sequence')->get();
	}

	public function delete($pivot_id)
	{
		$exercise_sequence = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('sequence');
		$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->detach();
		$this->workout_plan->exercises()->where('day', $this->day)->where('sequence', '>', $exercise_sequence)->decrement('sequence');
		// Reload component exercises
		$this->reloadExercises();
	}

	//  Idk why if I don't call reloadExercises it does not work
	public function edit($pivot_id)
	{
		$this->reloadExercises();
		$this->dispatch('edit-modal', pivot_id: $pivot_id);
	}

	public function add()
	{
		$this->reloadExercises();
		$this->dispatch('add-modal', day: $this->day);
	}
}
