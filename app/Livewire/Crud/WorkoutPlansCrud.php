<?php

namespace App\Livewire\Crud;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class WorkoutPlansCrud extends Component
{
    use WithPagination;

    // Parametri GET
    #[Url]
    public $user_id;
    #[Url]
    public $new_plan_user_id;

    public $is_user_admin;
    public $search_parameter;

    public $new = false;
    public $edit = false;

    public $modal_plan;
    public $showDetailsModal = false;

    public function render()
    {
        // Premuto il tasto "Crea scheda per questo utente" nel crud utenti
        if($this->new_plan_user_id) {
            $this->new = true;
            $this->showDetailsModal = true;
        }

        if($this->user_id)
            $results = WorkoutPlan::where('title', 'like', "%{$this->search_parameter}%")
                ->where('user_id', $this->user_id)
                ->paginate(20);
        else
            $results = WorkoutPlan::where('title', 'like', "%{$this->search_parameter}%")
                ->paginate(20);

        $this->is_user_admin = Auth::user()->is_admin;

        return view('livewire.crud.workout_plans', [
            'results' => $results
        ]);
    }

    public function delete($id)
    {
        WorkoutPlan::find($id)->delete();
    }

    public function create()
    {
        $this->modal_plan = null;

        $this->new = true;
        $this->edit = false;
        $this->showDetailsModal = true;
    }

    public function editPlan($id)
    {
        $this->modal_plan = WorkoutPlan::find($id);

        $this->new = false;
        $this->edit = true;
        $this->showDetailsModal = true;
    }

    public function save()
    {

    }
}
