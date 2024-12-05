<?php

namespace App\Livewire;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WorkoutDayEditor extends Component
{
    public $workout_plan_id;
    public $day;
    private $exercises;

    // Executed only when component is created
    public function mount()
    {
        $this->exercises = WorkoutPlan::find($this->workout_plan_id)->exercises()->where('day', $this->day)->orderBy('sequence')->get();
    }

    //  Executed every time a variable gets updated
    public function render()
    {
        return view('livewire.workout-day-editor', [
            'day' => $this->day,
            'exercises' => $this->exercises
        ]);
    }

    // Executed everytime an exercise gets moved
    public function updateOrder($updated_order)
    {
        // Update DB
        // TODO: Could be done with a single query
        foreach($updated_order as $item)
            DB::table('workout_plan_exercises')->where('id', $item['value'])->update(['sequence' => $item['order']]);

        // Reload component exercises
        $this->exercises = WorkoutPlan::find($this->workout_plan_id)->exercises()->where('day', $this->day)->orderBy('sequence')->get();
    }
}
