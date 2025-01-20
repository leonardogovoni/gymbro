<?php

namespace App\Livewire\Training;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

use App\Models\ExerciseData;

class DataModel extends Component
{
	public $workout_plan;
	public $day;
	public $current_index;
	public $max_index;
	public $saved = false;

	public $reps;
	public $used_kgs = [];
	public $last_training_kgs;

	// Executed only when component is created
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('order')-1;
		$this->change_index(0);
	}

	// Executed everytime a variable gets updated
	public function render()
	{
		return view('livewire.training.data-model');
	}

	public function submit()
	{
		foreach($this->used_kgs as $index => $kgs) {
			ExerciseData::create([
				'user_id' => auth()->id(),
				'exercise_id' => $this->exercises()[$this->current_index]->id,
				'workout_plan_pivot_id' => $this->exercises()[$this->current_index]->pivot->id,
				'set' => $index + 1,
				'reps' => $this->reps[$index],
				'used_kgs' => $kgs
			]);
		}

		$this->saved = true;
	}

	#[On('change-index')]
	public function change_index($new_index)
	{
		if($new_index > 0 || $new_index < $this->max_index) {
			$this->current_index = $new_index;
			$this->saved = false;
			$this->reps = $this->get_exercise_reps($this->exercises()[$this->current_index]->pivot->id);
			$this->last_training_kgs = $this->get_last_training_data($this->exercises()[$this->current_index]->pivot->id);
		}
	}

	#[Computed]
	public function exercises()
	{
		return $this->workout_plan->exercises()->where('day', $this->day)->orderBy('order')->get();
	}

	#[Computed]
	public function get_last_training_data($pivot_id) {
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		$result = ExerciseData::where('workout_plan_pivot_id', $exercise->pivot->id)
			->orderBy('id', 'desc')
			->take($exercise->pivot->sets)
			->get()
			->reverse()
			->pluck('used_kgs');

		if($result->isEmpty()) {
			return array_fill(0, $exercise->pivot->sets, "Non disponibile");
		}
		else {
			foreach($result as $index => $kgs)
				if((int)$kgs == $kgs)
					$result[$index] = (int)$kgs;
			return $result;
		}
	}

	#[Computed]
	public function get_exercise_reps($pivot_id) {
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		if(str_contains($exercise->pivot->reps, '-'))
			return explode('-', $exercise->pivot->reps);
		else
			return array_fill(0, $exercise->pivot->sets, $exercise->pivot->reps);
	}
}
