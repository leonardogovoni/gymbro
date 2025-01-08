<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseData;

class ExerciseDataModal extends Component
{
	public $exerciseId;
	public $series;
	public $repetitions;
	public $usedKg = [];

	public function mount($exerciseId, $series, $repetitions)
	{
		$this->exerciseId = $exerciseId;
		$this->series = $series;
		$this->repetitions = $repetitions;
		$this->usedKg = array_fill(0, $series, '');
	}

	public function render()
	{
		return view('livewire.exercise-data-modal');
	}

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
}
