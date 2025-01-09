<?php

namespace App\Livewire;

use Livewire\Component;

class ExerciseTimer extends Component
{
    public $rest;

    public function mount($rest)
    {
        $this->rest = $this->formatRest($rest);
    }

    private function formatRest($rest)
    {
        $minutes = floor($rest / 60); // Calcola i minuti interi
        $seconds = $rest % 60;       // Calcola i secondi rimanenti
        return sprintf('%d:%02d', $minutes, $seconds); // Formatta come mm:ss
    }

    public function render()
    {
        return view('livewire.exercise-timer');
    }
}
