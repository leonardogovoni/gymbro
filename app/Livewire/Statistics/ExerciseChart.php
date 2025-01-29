<?php

namespace App\Livewire\Statistics;

use Livewire\Component;
use App\Models\ExerciseData;
use App\Models\WorkoutPlan;

class ExerciseChart extends Component
{
	// Necessario per il CRUD
	public $user_id = null;
	public $crud_ui = false;

	public $exercise_id;
	public $switch_view = 0;
	public $switch_day = 0;
	public $switch_plan = 0;
	public $exercise_data;
	public $exercise_data_begin;
	public $workout_plan_ids;
	public $days = [];

	// Numero di mesi di cui visualizzare gli esercizi, default: 3
	public $switch_filter = '0';

	public function render()
	{
		// Stessa query richiamata piu' volte, a sto punto...
		$this->repeteadedQuery();

		// Estrai i nomi delle schede (workout_plan) in un array
		// $workout_plan = $this->exercise_data->pluck('workoutPlan.title')->filter(); // Rimuove i nulli
		$this->workout_plan_ids = WorkoutPlan::join('exercises_data', 'workout_plans.id', '=', 'exercises_data.workout_plan_id')
			->distinct()
			->pluck('workout_plans.id');

		// Seleziona i workout_plan con gli ID estratti
		$workout_plan = WorkoutPlan::whereIn('id', $this->workout_plan_ids)->pluck('title');

		// Estrai i pesi e le ripetizioni in array separati
		$weights = $this->exercise_data->pluck('used_weights');
		$reps = $this->exercise_data->pluck('reps');

		// Raccolta dei dati in un array
		$exercise_stats = [
			'max_kg' => $weights->max(),
			'min_kg' => $weights->min(),
			'average_kg' => round($weights->avg(), 2),
			'max_rep' => $reps->max(),
			'min_rep' => $reps->min(),
			'average_rep' => round($reps->avg(), 2)
		];

		// Non eliminare questa funzione, grazie, la direzione.
		$this->dispatch($this->switch_view ? 'updateChartReps' : 'updateChartKgs', $this->exercise_data);

		// [TODO] Questa parte andrebbe sistemata in una maniera piu' sintetica, altresi' spostare la logica
		// sul frontend crea dei papiri per non renderla indecente.
		return view('livewire.statistics.exercise-chart', [
			'exercise_data' => $this->exercise_data,
			'exercise_stats' => $exercise_stats,
			'workout_plans' => $workout_plan,
			'workout_plan_ids' => $this->workout_plan_ids,
			'days' => $this->days,
		]);
	}

	public function repeteadedQuery()
	{
		$query = ExerciseData::where('exercise_id', $this->exercise_id);

		// Gestire il filtro per user_id
		$query->when($this->user_id, function ($query) {
			return $query->where('user_id', $this->user_id);
		}, function ($query) {
			return $query->where('user_id', auth()->id());
		});

		// Gestire il filtro per $this->switch_filter (mesi)
		$query->when($this->switch_filter !== '0', function ($query) {
			return $query->where('created_at', '>=', now()->subMonths($this->switch_filter));
		});

		// Gestire il filtro per $this->switch_plan
		$query->when((int) $this->switch_plan !== 0, function ($query) {
			return $query->where('workout_plan_id', $this->workout_plan_ids[$this->switch_plan - 1]);
		});

		if ((int) $this->switch_plan !== 0)
			$this->days = $query->pluck('day')->unique()->sort()->values();
		else
			$this->days = [];

		// Gestire il filtro per $this->switch_day
		$query->when((int) $this->switch_day !== 0 && (int) $this->switch_plan !== 0, function ($query) {
			return $query->where('day', $this->switch_day);
		});

		// Ordina i risultati
		$this->exercise_data = $query->orderBy('created_at')->get();
	}

	// ==================================================
	// Listener delle variabili del file Blade

	// Questa funzione viene chiamata direttamente dal Blade per evitare
	// l'accrocchio che andrebbe altrimenti scritto qui sotto
	public function recall()
	{
		$this->repeteadedQuery();
		$this->dispatch($this->switch_view ? 'updateChartReps' : 'updateChartKgs', $this->exercise_data);
	}
}
