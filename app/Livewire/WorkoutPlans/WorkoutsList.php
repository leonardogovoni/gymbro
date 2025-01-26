<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;

class WorkoutsList extends Component
{
	public function render()
	{
		// Non e' possibile utilizzare $request nei componenti Livewire, si passa ad Auth
		$user = Auth::user();
		$workout_plans = $user->workout_plans;
		$show_delete_modal = false;
		
		return view('livewire.workout_plans.workouts-list', [
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

		return view('livewire.workout_plans.workouts-list');
	}

	public function delete($id) {
		// Ritorna null se non trova nulla
		$workout_plan = Auth::user()->workout_plans()->where('id', $id)->first();

		// Cancella solo se non è null
		$workout_plan && $workout_plan->delete();

		return view('livewire.workout_plans.workouts-list');
	}
}

