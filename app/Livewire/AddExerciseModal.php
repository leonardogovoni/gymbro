<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On; 

use App\Models\Exercise;
use App\Models\WorkoutPlan;

class AddExerciseModal extends Component
{
    public $workout_plan_id;
    public $day;
    public $search_parameter = '';
    public $categories =  ['muscolo 1', 'muscolo 2'];

    // Executed only when component is created
    public function render()
    {
        return view('livewire.add-exercise-modal', [
            'results' => Exercise::where('name', 'like', '%'.$this->search_parameter.'%')->get(),
            'categories' => $this->categories
        ]);
    }

    // Recieves data from the add button component
    #[On('add-modal')]
    public function open($day)
    {
        $this->day = $day;
        $this->dispatch('open-modal', 'add');
    }

    // Execute when you click on an exercise to add it
    public function add($new_exercise_id)
    {
        $last_exercise = WorkoutPlan::find($this->workout_plan_id)->exercises()->where('day', $this->day)->orderBy('sequence', 'desc')->first();
        $new_exercise_sequence = $last_exercise ? $last_exercise->pivot->sequence + 1 : 1;

        WorkoutPlan::find($this->workout_plan_id)->exercises()->attach($new_exercise_id, [
            'day' => $this->day,
            'sequence' => $new_exercise_sequence,
            'series' => 3,
            'repetitions' => 10,
            'rest' => 1
        ]);

        $this->dispatch('exercise-updated');
        $this->dispatch('close-modal', 'add_exercise');
    }
}
