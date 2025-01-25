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
	public $results;
	public $add_day;
	public $show_add_modal = false;

	// Variabili per modal di modifica
	public $edit_pivot_id;
	public $rest;
	public $sets;
	public $to_failure;
	public $same_reps;
	public $reps = [];
	public $show_edit_modal = false;

	// Eseguito ogni volta che una variabile cambia
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

		return view('livewire.workout_plans.workout-editor');
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

	// Necessario per usare il componente nel CRUD
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

	// Funzione per aggiornare l'ordine degli esercizi
	public function updateOrder($updated_order)
	{
		// TODO: Probabilmente si può fare in un'unica query
		foreach($updated_order as $item)
			$this->workout_plan->exercises()->wherePivot('id', $item['value'])->update(['order' => $item['order']]);
	}

	public function incrementDay()
	{
		$this->days++;
	}

	public function delete($pivot_id)
	{
		// Necessario per decrementare l'ordine degli esercizi successivi
		$exercise_order = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('order');
		$exercise_day = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->value('day');
		$this->workout_plan->exercises()->wherePivot('id', $pivot_id)->detach();
		$this->workout_plan->exercises()->where('day', $exercise_day)->where('order', '>', $exercise_order)->decrement('order');
	}

	// Funzione per il modal di aggiunta
	public function add($exercise_id)
	{
		// Ottengo l'order dell'ultimo esercizio del giorno per capire l'ordine del nuovo esercizio
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

	// Funzioni per il modal di modifica
	public function loadEdit($pivot_id)
	{
		$this->edit_pivot_id = $pivot_id;
		$exercise_data = $this->workout_plan->exercises()->wherePivot('id', $pivot_id)->first();

		// Preparo i dati per il modal
		$this->rest = $exercise_data->pivot->rest;
		$this->sets = $exercise_data->pivot->sets;
		$this->to_failure = $exercise_data->pivot->reps == 'MAX' ? true : false;
		$this->same_reps = !str_contains($exercise_data->pivot->reps, '-');
		$this->reps = explode('-', $exercise_data->pivot->reps);

        $this->show_edit_modal = true;
	}

	public function edit()
	{
		$reps_str = $this->to_failure ? 'MAX' : ($this->same_reps ? $this->reps[0] : implode('-', $this->reps));
		$this->workout_plan->exercises()->wherePivot('id', $this->edit_pivot_id)->update([
			'rest' => $this->rest,
			'sets' => $this->sets,
			'reps' => $reps_str,
			'edited' => true
		]);
		$this->show_edit_modal = false;
	}
}
