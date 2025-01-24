<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseData;

class ExerciseChart extends Component
{
	public $exerciseId;
	public $switchView = 0;
	public $exerciseData;

	// Numero di mesi di cui visualizzare gli esercizi, default: 3
	public $filter = '3';

	public function render()
	{
		// Stessa query richiamata piu' volte, a sto punto...
		$this->repeteadedQuery();

		// workaround per ottenere il numero di serie totali dell'esercizio coinvolto, quindi X x N
		// Nota: considerato che il calcolo viene svolto sotto, non si puo' dividere per 0, pero' 1:0 = 0
		// BUG [TODO]: vedere Notion
		$series = $this->exerciseData->count() === 0 ? 1 : $this->exerciseData[$this->exerciseData->count() - 1]->set;

		// Calcolo della media dei pesi usati
		$maxKg = $this->exerciseData->max('used_weights');
		$minKg = $this->exerciseData->min('used_weights');
		$averageKg = round($this->exerciseData->avg('used_weights'), 2);

		// Calcolo della media delle ripetizioni
		$maxRep = $this->exerciseData->max('reps');
		$minRep = $this->exerciseData->min('reps');
		$averageRep = round($this->exerciseData->avg('reps'), 2);

		// Non eliminare questa funzione, grazie, la direzione.
		$this->dispatch($this->switchView ? 'updateChartReps' : 'updateChartKgs', $this->exerciseData);

		return view('livewire.exercise-chart', [
			'exerciseData' => $this->exerciseData,
			'maxKg' => $maxKg,
			'minKg' => $minKg,
			'averageKg' => $averageKg,
			'maxRep' => $maxRep,
			'minRep' => $minRep,
			'averageRep' => $averageRep,

			// Ottiene il numero effettivo di allenamenti caricati, in quanto i dati presenti nel DB sono moltiplicati
			// per il numero di serie, un allenamento 3x10 conta 3 volte etc...
			'showGraph' => $this->exerciseData->count() / $series
		]);
	}
	
	public function repeteadedQuery()
	{
		$this->exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
		->where('user_id', auth()->id())
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
		$this->dispatch($this->switchView ? 'updateChartReps' : 'updateChartKgs', $this->exerciseData);
	}

	public function updatedSwitchView()
	{
		$this->repeteadedQuery();
		$this->dispatch($this->switchView ? 'updateChartReps' : 'updateChartKgs', $this->exerciseData);
	}
}
