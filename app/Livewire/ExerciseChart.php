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
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get();

        $maxKg = $exerciseData->max('used_weights');
        $minKg = $exerciseData->min('used_weights');

        $this->updatedFilter();
        return view('livewire.exercise-chart', ['exerciseData' => $exerciseData, 'maxKg'=> $maxKg, 'minKg'=> $minKg]);
    }

    public function updatedFilter()
    {
        if ($this->filter == '0') {
            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->orderBy('created_at')
                ->get();
        } else {
            $startDate = now()->subMonths($this->filter);

            $exerciseData = ExerciseData::where('exercise_id', $this->exerciseId)
                ->where('created_at', '>=', $startDate)
                ->orderBy('created_at')
                ->get();
        }

        $this->dispatch('updateChart', $exerciseData);
    }
}
