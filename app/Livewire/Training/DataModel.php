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

	// public $name;
	// public $image;
	// public $exerciseId;
	// public $series;
	// public $repetitions;
	// public $usedKg = [];

	// Executed only when component is created
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->current_index = 0;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('sequence')-1;



		// $this->count = $count;
		// $this->name = $name;
		// $this->image = $image;
		// $this->exerciseId = $exerciseId;
		// $this->series = $series;
		// $this->repetitions = $repetitions;
		// $this->usedKg = array_fill(0, $series, '');
	}

	// Executed everytime a variable gets updated
	public function render()
	{
		return view('livewire.training.data-model', [
			'day' => $this->day,
			'exercises' => $this->exercises,
			'current_index' => $this->current_index
		]);
	}

	// DA FARE
	public function submit()
	{
		foreach ($this->usedKg as $index => $kg) {
			ExerciseData::create([
				'user_id' => auth()->id(),
				'exercise_id' => $this->exerciseId,
				'sets' => $index + 1,
				'reps' => $this->repetitions,
				'used_kg' => $kg,
				'date' => now(),
			]);
		}

		session()->flash('message', 'Dati salvati con successo!');
	}

	#[On('change-index')]
	public function changeIndex($new_index)
	{
		if ($new_index > 0 || $new_index < $this->max_index)
			$this->current_index = $new_index;
	}

	#[Computed]
	public function exercises()
	{
		return $this->workout_plan->exercises()->where('day', $this->day)->orderBy('sequence')->get();
	}
}
