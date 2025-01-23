<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;
use Livewire\Attributes\On; 
use Livewire\Attributes\Computed;

class WorkoutEditor extends Component
{
	public $show_desc_editor = true;
	public $description;
	public $workout_plan;
	public $days;
	public $exercises = [];

	// Executed only when component is created
	public function mount()
	{
		$this->description = $this->workout_plan->description;
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

	// Executed everytime the 'description' gets updated
	// TODO - sistemare il nome della funzione in snake_case, necessita di modifiche anche su workout-editor.blade.php in quanto il sistema
	// adottato e' una convenzione specifica di Livewire e richiede espressamente il camelCase
	public function updatedDescription($desc) {
		// Aggiorna l'attributo 'description' sul database
		$this->workout_plan->update(['description' => $desc]);

		// Aggiorna la proprietà locale
		$this->description = $desc;
	}

	// Executed everytime an exercise gets moved
	public function update_order($updated_order)
	{
		// Update DB
		// TODO: Could be done with a single query
		foreach($updated_order as $item)
			$this->workout_plan->exercises()->wherePivot('id', $item['value'])->update(['order' => $item['order']]);
	}

	#[Computed]
	public function exercises($day)
	{
		return $this->workout_plan->exercises()->where('day', $day)->orderBy('order')->get();
	}

	public function delete($pivot_id)
	{
		$exercise_order = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('order');
		$exercise_day = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('day');
		$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->detach();
		$this->workout_plan->exercises()->where('day', $exercise_day)->where('order', '>', $exercise_order)->decrement('order');
	}

	public function add_day()
	{
		$this->days++;
	}
}
