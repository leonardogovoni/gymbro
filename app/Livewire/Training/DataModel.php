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

	// Eseguito solo al caricamento del componente
	public function mount($workout_plan, $day)
	{
		$this->workout_plan = $workout_plan;
		$this->day = $day;
		$this->max_index = $this->workout_plan->exercises()->where('day', $this->day)->max('order')-1;

		// Tutte le variabili necessarie vengono caricate quando un esercizio cambia,
		// quindi e' sufficiente cambiare l'index
		$this->changeIndex(0);
	}

	// Eseguito ogni qualvolta una variabile subisce una modifica al suo valore
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
				'workout_plan_id' => $this->workout_plan->id,
				'day' => $this->day,
				'set' => $index + 1,
				'reps' => $this->reps[$index],
				'used_weights' => $weight
			]);
		}

		if ($this->exercises()[$this->current_index]->pivot->edited) {
			$pivot_id = $this->exercises()[$this->current_index]->pivot->id;

			$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->update([
				'edited' => false
			]);
		}

		$this->saved = true;
	}

	// Prepara i dati per il prossimo esercizio
	#[On('change-index')]
	public function changeIndex($new_index)
	{
		// Questo previene un errore quando il numero di esercizi nella scheda e' uguale a 1
		if ($this->current_index === null)
			$this->current_index = 0;

		// Il controllo tra $new_index e $this->max_index deve essere necessariamente minore o uguale,
		// dato che 0 === 0 e il strettamente minore crea un errore
		if ($new_index > 0 || $new_index <= $this->max_index) {
			$this->current_index = $new_index;
			$this->saved = false;

			// Parsa i dati per il nuovo esercizio
			$this->is_to_failure = $this->isToFailure($this->exercises()[$this->current_index]->pivot->id);
			$this->reps = $this->getExerciseReps($this->exercises()[$this->current_index]->pivot->id);
			$this->last_training_weights = $this->getLastTrainingWeights($this->exercises()[$this->current_index]->pivot->id);
			$this->last_training_reps = $this->getLastTrainingReps($this->exercises()[$this->current_index]->pivot->id);
			$this->used_weights = [];

			if (!$this->is_to_failure && $this->reps != $this->last_training_reps && $this->last_training_reps[0] != "Non disponibile")
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
	public function isToFailure($pivot_id)
	{
		return $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first()->pivot->reps == 'MAX';
	}

	#[Computed]
	public function getExerciseReps($pivot_id)
	{
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		return str_contains($exercise->pivot->reps, '-')
			? collect(explode('-', $exercise->pivot->reps))
			: collect(array_fill(0, $exercise->pivot->sets, $exercise->pivot->reps));
	}

	#[Computed]
	public function getLastTrainingWeights($pivot_id)
	{
		return $this->getLastTrainingData($pivot_id, 'used_weights');
	}

	#[Computed]
	public function getLastTrainingReps($pivot_id)
	{
		return $this->getLastTrainingData($pivot_id, 'reps');
	}

	public function getLastTrainingData($pivot_id, $type) {
		// La query e' ridondante nelle funzioni sopra, visto che l'unica differenza sta nel computare l'else,
		// tanto vale fare un innesto e pulire un po' di codice doppio
		$exercise = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();
		$has_been_edited = $exercise->pivot->edited;

		$result = ExerciseData::where('workout_plan_pivot_id', $exercise->pivot->id)
			->orderBy('id', 'desc')
			->take($exercise->pivot->sets)
			->get()
			->reverse()
			->pluck($type);

		// Caso generico
		if ($result->isEmpty() || $has_been_edited)
			return array_fill(0, $exercise->pivot->sets, "Non disponibile");

		// Caso 'ripetizioni'
		if ($type === 'reps')
			return $result;

		// Caso 'kili'
		foreach ($result as $index => $kgs)
			if ((int) $kgs == $kgs) $result[$index] = (int) $kgs;
		
		return $result;
	}
}
