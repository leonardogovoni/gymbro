<?php

namespace App\Livewire\Training;

use Livewire\Component;
use App\Models\ExerciseData;

class DataModal extends Component
{
	public $count;
	public $name;
	public $image;
	public $exerciseId;
	public $series;
	public $repetitions;
	public $usedKg = [];

	public function mount($count, $name, $image, $exerciseId, $series, $repetitions)
	{
		$this->count = $count;
		$this->name = $name;
		$this->image = $image;
		$this->exerciseId = $exerciseId;
		$this->series = $series;
		$this->repetitions = $repetitions;
		$this->usedKg = array_fill(0, $series, '');
	}

	public function render()
	{
		return view('livewire.training.data-modal');
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
