<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;
use Livewire\Attributes\On; 
use Livewire\Attributes\Computed;

class WorkoutEditor extends Component
{
	public $workout_plan;
	public $days;
	public $exercises = [];

	// Executed only when component is created
	public function mount()
	{
		$this->days = $this->workout_plan->exercises()->max('day');
	}

	// Executed everytime a variable gets updated
	#[On('exercise-updated')]
	public function render()
	{
		return view('livewire.workout_plans.workout-editor', [
			'days' => $this->days,
			'description' => $this->workout_plan->description
		]);
	}

	// Executed everytime an exercise gets moved
	public function update_order($updated_order)
	{
		// Update DB
		// TODO: Could be done with a single query
		foreach($updated_order as $item)
			$this->workout_plan->exercises()->wherePivot('id', $item['value'])->update(['sequence' => $item['order']]);
	}

	#[Computed]
	public function exercises($day)
	{
		return $this->workout_plan->exercises()->where('day', $day)->orderBy('sequence')->get();
	}

	public function delete($pivot_id)
	{
		$exercise_sequence = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('sequence');
		$exercise_day = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('day');
		$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->detach();
		$this->workout_plan->exercises()->where('day', $exercise_day)->where('sequence', '>', $exercise_sequence)->decrement('sequence');
	}

	public function add_day()
	{
		$this->days++;
	}
}
