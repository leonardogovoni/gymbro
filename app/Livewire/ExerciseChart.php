<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ExerciseData;

class ExerciseChart extends Component
{
    public $exerciseId;
    public $filter = '3'; // Default: 3 mesi


    public function render()
    {
        $startDate = now()->subMonths($this->filter);

        // Ottieni i dati filtrati
        $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
            ->where('date', '>=', $startDate)
            ->orderBy('date')
            ->get();

        $maxKg = $exerciseData->max('used_kg');
        $minKg = $exerciseData->min('used_kg');

        $this->updatedFilter();
        return view('livewire.exercise-chart', ['exerciseData' => $exerciseData, 'maxKg'=> $maxKg, 'minKg'=> $minKg]);
    }

    public function updatedFilter()
    {
        if ($this->filter == '0') {
            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->orderBy('date')
                ->get();
        } else {
            $startDate = now()->subMonths($this->filter);

            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('date', '>=', $startDate)
                ->orderBy('date')
                ->get();
        }

        $this->dispatch('updateChart', $exerciseData);
    }
}
