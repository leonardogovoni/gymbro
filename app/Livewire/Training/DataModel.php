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
	public $saved;

	public $is_to_failure;
	public $reps;
	public $used_weights = [];
	public $last_training_weights;
	public $last_training_reps;
	public $show_last_training_reps;

	// Executed only when component is created
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('order')-1;

		// All the necessary variables get initialized when the
		// exercise changes, so we can simply call change_index
		$this->change_index(0);
	}

	// Executed everytime a variable gets updated
	public function render()
	{
		return view('livewire.training.data-model');
	}

	public function submit()
	{
		foreach($this->used_weights as $index => $weight) {
			ExerciseData::create([
				'user_id' => auth()->id(),
				'exercise_id' => $this->exercises()[$this->current_index]->id,
				'workout_plan_pivot_id' => $this->exercises()[$this->current_index]->pivot->id,
				'set' => $index + 1,
				'reps' => $this->reps[$index],
				'used_weights' => $weight
			]);
		}

		if($this->exercises()[$this->current_index]->pivot->edited) {
			$pivot_id = $this->exercises()[$this->current_index]->pivot->id;

			$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->update([
				'edited' => false
			]);
		}

		$this->saved = true;
	}

	// Prepares the data for the next exercise
	#[On('change-index')]
	public function change_index($new_index)
	{
		if($new_index > 0 || $new_index < $this->max_index) {
			$this->current_index = $new_index;
			$this->saved = false;

			// Parsing data for the new exercise to be displayed
			$this->is_to_failure = $this->is_to_failure($this->exercises()[$this->current_index]->pivot->id);
			$this->reps = $this->get_exercise_reps($this->exercises()[$this->current_index]->pivot->id);
			$this->last_training_weights = $this->get_last_training_weights($this->exercises()[$this->current_index]->pivot->id);
			$this->last_training_reps = $this->get_last_training_reps($this->exercises()[$this->current_index]->pivot->id);

			if(!$this->is_to_failure && $this->reps != $this->last_training_reps && $this->last_training_reps[0] != "Non disponibile")
				$this->show_last_training_reps = true;
			else
				$this->show_last_training_reps = false;

			$this->dispatch('newRestTime', $this->exercises()[$this->current_index]->pivot->rest);
		}
	}

	#[Computed]
	public function exercises()
	{
		return $this->workout_plan->exercises()->where('day', $this->day)->orderBy('order')->get();
	}

	#[Computed]
	public function get_exercise_reps($pivot_id)
	{
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		if(str_contains($exercise->pivot->reps, '-'))
			return collect(explode('-', $exercise->pivot->reps));
		else
			return collect(array_fill(0, $exercise->pivot->sets, $exercise->pivot->reps));
	}

	#[Computed]
	public function is_to_failure($pivot_id)
	{
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		return $exercise->pivot->reps == 'MAX';
	}

	#[Computed]
	public function get_last_training_weights($pivot_id)
	{
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();
		
		$has_been_edited = $exercise->pivot->edited;
		$result = ExerciseData::where('workout_plan_pivot_id', $exercise->pivot->id)
			->orderBy('id', 'desc')
			->take($exercise->pivot->sets)
			->get()
			->reverse()
			->pluck('used_weights');

		if($result->isEmpty() || $has_been_edited) {
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
	public function get_last_training_reps($pivot_id)
	{
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		$has_been_edited = $exercise->pivot->edited;
		$result = ExerciseData::where('workout_plan_pivot_id', $exercise->pivot->id)
			->orderBy('id', 'desc')
			->take($exercise->pivot->sets)
			->get()
			->reverse()
			->pluck('reps');

		if($result->isEmpty() || $has_been_edited)
			return array_fill(0, $exercise->pivot->sets, "Non disponibile");
		else
			return $result;
	}
}
