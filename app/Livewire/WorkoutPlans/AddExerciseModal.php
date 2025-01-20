<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;
use Livewire\Attributes\On; 

use App\Models\Exercise;

class AddExerciseModal extends Component
{
	public $workout_plan;
	public $day;

	public $categories;
	public $search_parameter;
	public $category_parameter;

	// Executed only when component is created
	public function mount()
	{
		$this->categories = Exercise::orderBy('muscle')->distinct()->pluck('muscle');
	}

	// Executed everytime a variable gets updated
	public function render()
	{
		if(is_null($this->category_parameter) || $this->category_parameter == 'all')
			$result = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')->get();
		else
			$result = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')
						->where('muscle', '=', $this->categories[$this->category_parameter])
						->get();

		return view('livewire.workout_plans.add-exercise-modal', [
			'results' => $result,
			'categories' => $this->categories
		]);
	}

	// Recieves data from the add button component
	#[On('add')]
	public function open($day)
	{
		$this->day = $day;
		$this->dispatch('open-modal', 'add');
	}

	// Executed when you click on an exercise to add it
	public function add($new_exercise_id)
	{
		$last_exercise = $this->workout_plan->exercises()->where('day', $this->day)->orderBy('order', 'desc')->first();
		$new_exercise_order = !is_null($last_exercise) ? $last_exercise->pivot->order + 1 : 1;

		$this->workout_plan->exercises()->attach($new_exercise_id, [
			'day' => $this->day,
			'order' => $new_exercise_order,
			'sets' => 3,
			'reps' => 10,
			'rest' => 30
		]);

		$this->dispatch('exercise-updated');
		$this->dispatch('close-modal', 'add');
	}
}
