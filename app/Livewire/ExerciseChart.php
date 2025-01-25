<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseData;

class ExerciseChart extends Component
{
	// Necessario per il CRUD
	public $user_id = null;
	public $crud_ui = false;

	public $exercise_id;
	public $switch_view = 0;
	public $exercise_data;

	// Numero di mesi di cui visualizzare gli esercizi, default: 3
	public $filter = '3';

	public function render()
	{
		// Stessa query richiamata piu' volte, a sto punto...
		$this->repeteadedQuery();

		// workaround per ottenere il numero di serie totali dell'esercizio coinvolto, quindi X x N
		// Nota: considerato che il calcolo viene svolto sotto, non si puo' dividere per 0, pero' 1:0 = 0
		// BUG [TODO]: vedere Notion
		$series = $this->exercise_data->count() === 0 ? 1 : $this->exercise_data[$this->exercise_data->count() - 1]->set;

		// Calcolo della media dei pesi usati
		$maxKg = $this->exercise_data->max('used_weights');
		$minKg = $this->exercise_data->min('used_weights');
		$averageKg = round($this->exercise_data->avg('used_weights'), 2);

		// Calcolo della media delle ripetizioni
		$maxRep = $this->exercise_data->max('reps');
		$minRep = $this->exercise_data->min('reps');
		$averageRep = round($this->exercise_data->avg('reps'), 2);

		// Non eliminare questa funzione, grazie, la direzione.
		$this->dispatch($this->switch_view ? 'updateChartReps' : 'updateChartKgs', $this->exercise_data);

		// [TODO] Questa parte andrebbe sistemata in una maniera piu' sintetica, altresi' spostare la logica
		// sul frontend crea dei papiri per non renderla indecente.
		return view('livewire.exercise-chart', [
			'exercise_data' => $this->exercise_data,
			'maxKg' => $maxKg,
			'minKg' => $minKg,
			'averageKg' => $averageKg,
			'maxRep' => $maxRep,
			'minRep' => $minRep,
			'averageRep' => $averageRep,

			// Ottiene il numero effettivo di allenamenti caricati, in quanto i dati presenti nel DB sono moltiplicati
			// per il numero di serie, un allenamento 3x10 conta 3 volte etc...
			'show_graph' => $this->exercise_data->count() / $series
		]);
	}
	
	public function repeteadedQuery()
	{
		$this->exercise_data = ExerciseData::where('exercise_id', $this->exercise_id)
			// la prima funzione viene eseguita quando la condizione e' vera, la seconda quando e' falsa
			->when($this->user_id, function ($query) {
				return $query->where('user_id', $this->user_id);
			}, function ($query) {
				return $query->where('user_id', auth()->id());
			})
			// 'when' viene eseguito solo quando la condizione e' soddisfatta
			->when($this->filter !== '0', function ($query) {
				return $query->where('created_at', '>=', now()->subMonths($this->filter));
			})
			->orderBy('created_at')
			->get();
	}
	
	// ==================================================
	// Listener delle variabili del file Blade

	public function updatedFilter()
	{
		$this->repeteadedQuery();
		$this->dispatch($this->switch_view ? 'updateChartReps' : 'updateChartKgs', $this->exercise_data);
	}

	public function updatedSwitchView()
	{
		$this->repeteadedQuery();
		$this->dispatch($this->switch_view ? 'updateChartReps' : 'updateChartKgs', $this->exercise_data);
	}
}
