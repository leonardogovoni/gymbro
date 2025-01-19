<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;

class WorkoutButtonMenu extends Component
{
	public $show_delete_modal = false;

	public function render()
	{
		// Non e' possibile utilizzare $request nei componenti Livewire, si passa ad Auth
		$user = Auth::user();
		$workout_plans = $user->workout_plans;
		$show_delete_modal = false;
		
		return view('livewire.workout_plans.workout-button-menu', [
			'workout_plans' => $workout_plans,
			'show_delete_modal' => $this->show_delete_modal
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

		return view('livewire.workout_plans.workout-button-menu');
	}

	public function delete($wp) {
		// Indipendentemente dall'esito, il modale va chiuso
		$this->show_delete_modal = false;
		
		$user = Auth::user();
		$delete_wp = WorkoutPlan::findOrFail($wp);

		if ($delete_wp)
			$delete_wp->delete();

		return view('livewire.workout_plans.workout-button-menu');
	}
}

