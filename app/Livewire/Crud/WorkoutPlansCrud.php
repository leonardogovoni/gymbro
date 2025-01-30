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
	public $user_string;

	// Parametro GET, usato dal tasto "Mostra schede di questo utente" nel CRUD utenti
	#[Url]
	public $user_id;

	// Variabili per modale
	#[Validate('required', message: 'Il campo Titolo è obbligatorio.')]
	public $title;
	public $description;
	public $default;
	public $new_plan_user_id;

	// Parametri di ricerca
	public $search_parameter;
	public $search_user_modal_parameter;
	public $search_user_modal_results = [];

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

		// Ricerca utenti per il modale di creazione scheda
		if($this->new)
			$this->search_user_modal_results = User::where(function ($query) {
				$query->where('first_name', 'like', "%{$this->search_user_modal_parameter}%")
					->orWhere('last_name', 'like', "%{$this->search_user_modal_parameter}%")
					->orWhere('email', 'like', "%{$this->search_user_modal_parameter}%");
			})
			->when(!$this->is_admin && $this->is_gym, function ($query) {
				$query->where('controlled_by', '=', $this->gym_id);
			})
			->limit(8)
			->get();

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
		$this->user_string = $this->modal_plan->user->first_name . ' ' . $this->modal_plan->user->last_name . ' (' . $this->modal_plan->user->email . ')';
	
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
			// L'operatore non ha selezionato un utente
			if($this->new_plan_user_id == null)
				return;

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
		$this->user_string = null;
		$this->new = false;
		$this->show_details_modal = false;
	}

	public function removeFilter()
	{
		$this->user_id = null;
	}

	public function selectUser($id)
	{
		$user = $this->safeGetUser($id);

		// La palestra ha cercato di forzare di inserire un utente non suo
		if($user == null)
			return;

		$this->new_plan_user_id = $id;
		$this->user_string = $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')';
		$this->search_user_modal_parameter = null;
		$this->search_user_modal_results = [];
	}

	public function undoUserSelect()
	{
		$this->new_plan_user_id = null;
		$this->user_string = null;
	}
}
