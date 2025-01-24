<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseData;

class ExerciseChart extends Component
{
    public $exerciseId;
    public $filter = '3'; // Default: 3 mesi
    public $switchView = false;


    public function render()
    {
        $startDate = now()->subMonths($this->filter);

        // Ottieni i dati filtrati
        $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
            ->where('user_id', auth()->id()) // Filtro per l'utente loggato
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get();

        $maxKg = $exerciseData->max('used_weights');
        $minKg = $exerciseData->min('used_weights');
        $averageKg = round($exerciseData->avg('used_weights'), 2); // Media dei pesi usati

        $maxRep = $exerciseData->max('reps');
        $minRep = $exerciseData->min('reps');
        $averageRep = round($exerciseData->avg('reps'), 2); // Media reps fatte

        $this->updatedFilter();
        return view('livewire.exercise-chart', ['exerciseData' => $exerciseData,
         'maxKg' => $maxKg, 'minKg' => $minKg, 'averageKg' => $averageKg,
        'maxRep' => $maxRep, 'minRep' => $minRep, 'averageRep' => $averageRep]);
    }

    public function updatedFilter()
    {
        if ($this->filter == '0') {
            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('user_id', auth()->id()) // Filtro per l'utente loggato
                ->orderBy('created_at')
                ->get();
        } else {
            $startDate = now()->subMonths($this->filter);

            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('user_id', auth()->id()) // Filtro per l'utente loggato
                ->where('created_at', '>=', $startDate)
                ->orderBy('created_at')
                ->get();
        }

        if ($this->switchView) {
            $this->dispatch('updateChartReps', $exerciseData);
        } else {
            $this->dispatch('updateChartKgs', $exerciseData);
        }
    }

    public function updatedSwitchView()
    {
        if ($this->filter == '0') {
            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('user_id', auth()->id()) // Filtro per l'utente loggato
                ->orderBy('created_at')
                ->get();
        } else {
            $startDate = now()->subMonths($this->filter);

            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('user_id', auth()->id()) // Filtro per l'utente loggato
                ->where('created_at', '>=', $startDate)
                ->orderBy('created_at')
                ->get();
        }

        if ($this->switchView) {
            $this->dispatch('updateChartReps', $exerciseData);
        } else {
            $this->dispatch('updateChartKgs', $exerciseData);
        }
    }
}
