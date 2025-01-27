<?php

namespace App\Livewire\Crud;

use App\Models\User;
use App\Models\WorkoutPlan;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Url;

class WorkoutPlansCrud extends Component
{
	use WithPagination;

	// Parametri GET
	#[Url]
	public $user_id;
	#[Url]
	public $new_plan_user_id;

	// Variabili per modale
	public $modal_plan;
	public $title;
	public $description;
	public $default;
	public $user_not_found = false;

	// Variabili di controllo
	public $is_user_admin;
	public $search_parameter;
	public $new = false;
	public $show_details_modal = false;

	// Eseguito a ogni modifica di una variabile
	public function render()
	{
		// Premuto il tasto "Mostra schede dell'utente" nel CRUD utenti ('dettagli')
		$results = WorkoutPlan::where('title', 'like', "%{$this->search_parameter}%")
			->when($this->user_id, function ($query) {
				return $query->where('user_id', $this->user_id);
			})
			->paginate(20);

		$this->is_user_admin = Auth::user()->is_admin;

		return view('livewire.crud.workout_plans', [
			'results' => $results
		]);
	}

	// Eseguito quando il componente viene montato
	public function mount()
	{
		// Premuto il tasto "Crea scheda per questo utente" nel CRUD utenti
		if ($this->new_plan_user_id) {
			$this->new = true;
			$this->show_details_modal = true;
		}
	}

	public function delete($id)
	{
		WorkoutPlan::find($id)->delete();
	}

	public function create()
	{
		$this->new_plan_user_id = null;
		$this->modal_plan = null;
		$this->title = null;
		$this->description = null;
		$this->default = null;

		$this->user_not_found = false;
		$this->new = true;
		$this->show_details_modal = true;
	}

	public function editPlan($id)
	{
		$this->modal_plan = WorkoutPlan::find($id);

		$this->title = $this->modal_plan->title;
		$this->description = $this->modal_plan->description;
		$this->default = $this->modal_plan->enabled;
		
		$this->new_plan_user_id = $this->modal_plan->user_id;
		$this->new = false;
		$this->show_details_modal = true;
	}

	public function makeDefault()
	{
		WorkoutPlan::where('user_id', $this->modal_plan->user_id)->update(['enabled' => 0]);
		WorkoutPlan::find($this->modal_plan->id)->update(['enabled' => 1]);
		$this->modal_plan->enabled = true;
	}

	public function save()
	{
		// Nuova scheda
		if ($this->new) {
			// Utente non trovato
			if(User::find($this->new_plan_user_id) == null) {
				$this->user_not_found = true;
				return;
			}

			// Select è un po' particolare
			switch ($this->default) {
				// Si controlla prima 1, il che implica che l'utente vuole creare una scheda con default 'Si',
				// quindi si mettono a 'false' tutte le altre
				case '1':	$this->default = 1;
							WorkoutPlan::where('user_id', $this->new_plan_user_id)->update(['enabled' => 0]);
							break;
				
				// In tutti i casi in cui la scheda non viene selezionata come 'Attiva', allora e' per forza NON default
				default:	$this->default = 0;
							break;
			}

			// Finito il settaggio, si crea la nuova scheda
			WorkoutPlan::create([
				'user_id' => $this->new_plan_user_id,
				'title' => $this->title,
				'description' => $this->description,
				'enabled' => $this->default
			]);
		}
		// Modifica scheda esistente
		else {
			$this->modal_plan->update([
				'title' => $this->title,
				'description' => $this->description
			]);
		}

		$this->new_plan_user_id = null;
		$this->user_not_found = false;
		$this->new = false;
		$this->edit = false;
		$this->show_details_modal = false;
	}

	public function removeFilter()
	{
		$this->user_id = null;
	}
}
