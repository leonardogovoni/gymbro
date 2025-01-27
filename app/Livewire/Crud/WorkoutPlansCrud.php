<?php

namespace App\Livewire\Crud;

use App\Models\User;
use App\Models\WorkoutPlan;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;

class WorkoutPlansCrud extends Component
{
	use WithPagination;

	// Variabili di controllo per permessi
	public $is_admin;
	public $is_gym;
	public $gym_id;

	// Variabili per la gestione del modale
	public $new = false;
	public $modal_plan;
	public $show_details_modal = false;
	public $user_not_found = false;

	// Parametro GET, usato dal tasto "Mostra schede di questo utente" nel CRUD utenti
	#[Url]
	public $user_id;

	// Variabili per modale
	#[Validate('required', message: 'Il campo Titolo è obbligatorio.')]
	public $title;
	public $description;
	public $default;
	// Parametro GET, usato dal tasto "Crea scheda per questo utente" nel CRUD utenti
	#[Url]
	public $new_plan_user_id;

	// Variabili di controllo
	public $search_parameter;

	// Eseguito a ogni modifica di una variabile
	public function render()
	{
		// Ritorna le schede che hanno titolo simile a $this->search_parameter
		// o che appartengono a utenti con nome simie; se non è admin ritorna
		// solo schede di clienti della palestra con tali caratteristiche
		$results = WorkoutPlan::join('users', 'workout_plans.user_id', '=', 'users.id')
			->where(function ($query) {
				$query->where('users.first_name', 'like', "%{$this->search_parameter}%")
					->orWhere('users.last_name', 'like', "%{$this->search_parameter}%")
					->orWhere('workout_plans.title', 'like', "%{$this->search_parameter}%");
			})
			->when(!$this->is_admin && $this->is_gym, function ($query) {
				$query->where('users.controlled_by', '=', $this->gym_id);
			})
			// L'utente ha premutto il tasto "Mostra schede di questo utente" nel CRUD utenti
			->when($this->user_id, function ($query) {
				$query->where('users.id', '=', $this->user_id);
			})
			->select('workout_plans.id' , 'workout_plans.title', 'users.first_name', 'users.last_name', 'workout_plans.enabled')
			->paginate(20);

		return view('livewire.crud.workout_plans', [
			'results' => $results
		]);
	}

	// Eseguito solo al mount
	public function mount()
	{
		// Controllo permessi
		$user = Auth::user();
		$this->is_admin = $user->is_admin;
		$this->is_gym = $user->is_gym;
		$this->gym_id = $user->id;

		// // Premuto il tasto "Crea scheda per questo utente" nel CRUD utenti
		if ($this->new_plan_user_id) {
			$this->new = true;
			$this->show_details_modal = true;
		}
	}

	// Ogni volta che devo cercare una scheda uso questa funzione
	// Impedisce a un utente palestra malintenzionato di cercare schede di altre palestre
	function safeGetPlan($id)
	{
		return $this->is_admin
			? WorkoutPlan::where('id', $id)->firstOrFail()
			: WorkoutPlan::whereIn('user_id', Auth::user()->gym_clients()->pluck('id'))->where('id', $id)->firstOrFail();
	}

	// Ogni volta che devo cercare un utente uso questa funzione
	function safeGetUser($id)
	{
		return $this->is_admin
			? User::where('id', $id)->first()
			: Auth::user()->gym_clients()->where('id', $id)->first();
	}

	public function delete($id)
	{
		$this->safeGetPlan($id)->delete();
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

	// Chiamarlo solo inspect rompe tutto
	public function inspectPlan($id)
	{
		$this->new = false;
		$this->modal_plan = $this->safeGetPlan($id);

		$this->title = $this->modal_plan->title;
		$this->description = $this->modal_plan->description;
		$this->default = $this->modal_plan->enabled;
		$this->new_plan_user_id = $this->modal_plan->user_id;

		$this->show_details_modal = true;
	}

	// Questa è già sicura, in quanto l'id viene preso dal
	// plan che è stato già caricato con safeGetPlan
	public function makeDefault()
	{
		WorkoutPlan::where('user_id', $this->modal_plan->user_id)->update(['enabled' => 0]);
		$this->modal_plan->enabled = true;
		$this->modal_plan->save();
	}

	public function save()
	{
		// Nuova scheda
		if ($this->new) {
			// Controllo se l'utente è della palestra o (nel caso di admin) se esiste
			if($this->safeGetUser($this->new_plan_user_id) == null) {
				$this->user_not_found = true;
				return;
			}

			// Select è un po' particolare
			if($this->default == '1') {
				WorkoutPlan::where('user_id', $this->new_plan_user_id)->update(['enabled' => 0]);
				$this->default = 1;	
			}
			else
				$this->default = 0;

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
		$this->show_details_modal = false;
	}

	public function removeFilter()
	{
		$this->user_id = null;
	}
}
