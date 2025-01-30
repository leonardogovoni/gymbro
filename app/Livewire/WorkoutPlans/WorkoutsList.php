<?php

namespace App\Livewire\WorkoutPlans;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;

class WorkoutsList extends Component
{
	#[Validate('required', message: 'Il campo Nome è obbligatorio.')]
	public $title;
	public $description;
	public $edit_workout_plan;
	public $show_edit_modal = false;

	public function render()
	{
		// Non e' possibile utilizzare $request nei componenti Livewire, si passa ad Auth
		$user = Auth::user();
		$workout_plans = $user->workout_plans;
		$show_delete_modal = false;
		
		return view('livewire.workout-plans.workouts-list', [
			'workout_plans' => $workout_plans
		]);
	}

	public function enable($wp)
	{
		$user = Auth::user();

		// Pesca la scheda attiva da 'disattivare', potrebbe dare errore se il processo e' stato:
		// > eliminazione attiva > settaggio nuova
		// si effettua un controllo per sicurezza
		$default_wp = $user->workout_plans()->where('enabled', true)->first();
		if ($default_wp) {
			$default_wp->enabled = 0;
			$default_wp->save();
		}

		// Si imposta ad attiva la scheda scelta dall'utente, non essendocene altre a livello di utente
		// eseguire le operazioni in questo ordine dovrebbe prevenire errori in 'training'
		$wp = WorkoutPlan::find($wp);
		if ($wp) {
			$wp->enabled = 1;
			$wp->save();
		}

		return view('livewire.workout-plans.workouts-list');
	}

	public function edit($id)
	{
		$this->edit_workout_plan = Auth::user()->workout_plans()->where('id', $id)->first();

		if ($this->edit_workout_plan) {
			$this->title = $this->edit_workout_plan->title;
			$this->description = $this->edit_workout_plan->description;
			$this->show_edit_modal = true;
		}
	}

	public function save()
	{
		$this->validate();

		if ($this->edit_workout_plan)
			$this->edit_workout_plan->update([
				'title' => $this->title,
				'description' => $this->description
			]);

		$this->show_edit_modal = false;
	}

	public function delete($id)
	{
		// Ritorna null se non trova nulla
		$workout_plan = Auth::user()->workout_plans()->where('id', $id)->first();

		// Cancella solo se non è null
		$workout_plan && $workout_plan->delete();

		return view('livewire.workout-plans.workouts-list');
	}
}

