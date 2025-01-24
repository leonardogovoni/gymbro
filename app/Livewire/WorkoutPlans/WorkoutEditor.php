<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

use App\Models\Exercise;

class WorkoutEditor extends Component
{
	public $show_desc_editor = true;
	public $description;

	// Variabili editor in sé
	#[Reactive]
	public $workout_plan;
	public $days;
	public $exercises = [];

	// Variabili per modal di aggiunta
	public $categories;
	public $search_parameter;
	public $category_parameter;
	public $results = [];
	public $add_day = 0;
	public $show_add_modal = false;

	// Eseguito ogni volta che una variabile cambia
	#[On('exercise-updated')]
	public function render()
	{
		// Ricerca esercizi
		if(is_null($this->category_parameter) || $this->category_parameter == 'all')
			$this->results = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')->get();
		else
			$this->results = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')
						->where('muscle', '=', $this->categories[$this->category_parameter])
						->get();

		$this->description = $this->workout_plan->description;

		return view('livewire.workout_plans.workout-editor', [
			'days' => $this->days,
			'description' => $this->workout_plan->description
		]);
	}

	// Eseguito all'inizializzazione del componente
	public function mount()
	{
		$this->categories = Exercise::orderBy('muscle')->distinct()->pluck('muscle');
		$this->reloadDays();	
	}

	#[Computed]
	public function exercises($day)
	{
		return $this->workout_plan->exercises()->where('day', $day)->orderBy('order')->get();
	}

	#[On('workout-plan-changed')]
	public function reloadDays()
	{
		$this->days = $this->workout_plan->exercises()->max('day');
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
	public function updateOrder($updated_order)
	{
		// Update DB
		// TODO: Could be done with a single query
		foreach($updated_order as $item)
			$this->workout_plan->exercises()->wherePivot('id', $item['value'])->update(['order' => $item['order']]);
	}

	public function delete($pivot_id)
	{
		$exercise_order = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('order');
		$exercise_day = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('day');
		$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->detach();
		$this->workout_plan->exercises()->where('day', $exercise_day)->where('order', '>', $exercise_order)->decrement('order');
	}

	public function incrementDay()
	{
		$this->days++;
	}

	public function add($exercise_id)
	{
		$last_exercise = $this->workout_plan->exercises()->where('day', $this->add_day)->orderBy('order', 'desc')->first();
		$new_exercise_order = !is_null($last_exercise) ? $last_exercise->pivot->order + 1 : 1;

		$this->workout_plan->exercises()->attach($exercise_id, [
			'day' => $this->add_day,
			'order' => $new_exercise_order,
			'sets' => 3,
			'reps' => 10,
			'rest' => 30
		]);

		$this->show_add_modal = false;
	}
}
