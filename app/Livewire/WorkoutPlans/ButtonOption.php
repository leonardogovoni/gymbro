<?php

namespace App\Livewire\WorkoutPlans;

use Livewire\Component;

use App\Models\WorkoutPlan;
use Illuminate\Support\Facades\Auth;

class ButtonOption extends Component
{
	public $workout_plan;
	public $enabled_schema = false;

	public function mount($wp)
	{
		$this->workout_plan = $wp;

		// Aggiorna dinamicamente il pulsante e ne determina o meno la presenza nel Blade
		if (!$this->workout_plan->enabled) {
			$this->enabled_schema = true;
		}
	}

	public function enable()
	{
		// Non e' possibile utilizzare $request nei componenti Livewire, si passa ad Auth
		$user = Auth::user();

		// L'esito dovrebbe dare sempre esito positivo visto che l'unico modo per accedere a questa scheda
		// e' essere loggati ma per sicurezza, il controllino lo piazzo ugualmente
		if ($user) {
			// Pesca la scheda attiva da 'disattivare', potrebbe dare errore se il processo e' stato:
			// > eliminazione attiva > settaggio nuova
			// si effettua un controllo per sicurezza
			$enabled = $user->workout_plans()->where('enabled', true)->first();
			if ($enabled) {
				$enabled->enabled = 0;
				$enabled->save();

				// Il pulsante per reimpostare il default torna disponibile, essendo quello stato andato perso
				$this->enabled_schema = true;
			}

			// Si imposta ad attiva la scheda scelta dall'utente, non essendocene altre a livello di utente
			// eseguire le operazioni in questo ordine dovrebbe prevenire errori in 'training'
			if ($this->workout_plan) {
				$this->workout_plan->enabled = 1;
				$this->workout_plan->save();

				// Qui viene disattivato
				$this->enabled_schema = false;
			}
		}

		// [TODO] So che si può fare in maniera migliore ma dopo 3h che cerco di capire come fixare sta parte, ci rinuncio
		// Fixatelo voi, in pratica il 'problema' e' che senza un aggiornamento della view, le icone che permettono di impostare un'altra
		// scheda a default e il testo 'Abilitato: Si/No' rimangono fissi finche' non si riaggiorna
		return redirect()->route('workout_plans.list');
	}

	public function render()
	{
		return view('livewire.workout_plans.button-option');
	}
}

