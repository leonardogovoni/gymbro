<?php

namespace App\Livewire\Crud;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class UsersCrud extends Component
{
	use WithPagination;

	// Variabili di controllo per permessi
	public $is_admin;
	public $is_gym;
	public $gym_id;

	// Variabili per la gestione del modale
	public $new = false;
	public $modal_user;
	public $show_details_modal = false;
	public $user_already_exists = false;

	// Variabili del modale
	#[Validate('required', message: 'Il campo Nome è obbligatorio.')]
	public $first_name;
	#[Validate('required', message: 'Il campo Cognome è obbligatorio.')]
	public $last_name;
	#[Validate('required', message: 'Il campo Codice fiscale è obbligatorio.')]
	#[Validate('min:16', message: 'Codice fiscale inserito non valido.')]
	public $ssn;
	#[Validate('required', message: 'Il campo Email è obbligatorio.')]
	#[Validate('email', message: 'Email inserita non valida.')]
	public $email;
	#[Validate('required', message: 'Il campo Sesso è obbligatorio.')]
	public $gender;
	#[Validate('required', message: 'Il campo Data di nascita è obbligatorio.')]
	public $birth_date;
	public $is_admin_form;
	public $is_gym_form;
	public $controlled_by;

	public $search_parameter;

	// Eseguita a ogni render
	public function render()
	{
		$results = User::where(function ($query) {
				$query->where('first_name', 'like', "%{$this->search_parameter}%")
					->orWhere('last_name', 'like', "%{$this->search_parameter}%")
					->orWhere('email', 'like', "%{$this->search_parameter}%");
				})
			// Quando non è admin ma è palestra, mostra solo i clienti della palestra
			->when(!$this->is_admin && $this->is_gym, function ($query) {
				$query->where('controlled_by', '=', $this->gym_id);
			})
			->paginate(20);

		return view('livewire.crud.users', [
			'results' => $results
		]);
	}

	// Eseguita solo al mount
	public function mount()
	{
		$this->is_admin = Auth::user()->is_admin;
		$this->is_gym = Auth::user()->is_gym;
		$this->gym_id = Auth::user()->id;
	}

	// Ogni volta che devo cercare un utente uso questa funzione
	// Impedisce a un utente palestra malintenzionato di cercare utenti di altre palestre
	function gymOrAdminHandler($id)
	{
		if($this->is_admin)
			return User::where('id', $id)->firstOrFail();
		else
			return Auth::user()->gym_clients()->where('id', $id)->firstOrFail();
	}

	public function delete($id)
	{
		// DA CONTROLLARE, ma quando cancello un utente
		// con schede dovrebbe eliminarle già così
		$this->gymOrAdminHandler($id)->delete();
	}

	public function create()
	{
		$this->new = true;
		$this->modal_user = null;

		// Resetto i campi del modale
		$this->first_name = '';
		$this->last_name = '';
		$this->ssn = '';
		$this->email = '';
		$this->gender = '';
		$this->birth_date = '';
		$this->is_admin_form = '';
		$this->is_gym_form = '';
		$this->controlled_by = '';

		$this->show_details_modal = true;
	}

	// Chiamarlo solo inspect rompe tutto
	public function inspectUser($id)
	{
		$this->new = false;
		$this->modal_user = $this->gymOrAdminHandler($id);

		// Carico i dati dell'utente nelle variabili del modale
		$this->first_name = $this->modal_user->first_name;
		$this->last_name = $this->modal_user->last_name;
		$this->ssn = $this->modal_user->ssn;
		$this->email = $this->modal_user->email;
		$this->gender = $this->modal_user->gender;
		$this->birth_date = $this->modal_user->date_of_birth;
		if($this->is_admin) {
			$this->is_admin_form = $this->modal_user->is_admin ? true : false;
			$this->is_gym_form = $this->modal_user->is_gym ? true : false;
			$this->controlled_by = $this->modal_user->controlled_by;
		}

		$this->show_details_modal = true;
	}

	public function save()
	{
		$this->validate();

		// Se è un nuovo utente ma la mail è già presente
		if($this->new && User::where('email', $this->email)->first() != null) {
			$this->user_already_exists = true;
			return;
		}

		// Dovrei scrivere sto dizionario sia per la creazione che per la modifica
		$data = [
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'ssn' => $this->ssn,
			'email' => $this->email,
			'gender' => $this->gender,
			'date_of_birth' =>  $this->birth_date,
			'is_admin' => ($this->is_admin && $this->is_admin_form) ? true : false,
			'is_gym' => ($this->is_admin && $this->is_gym_form) ? true : false,
		];

		if($this->is_admin && $this->controlled_by)
			$data['controlled_by'] = $this->controlled_by;
		elseif($this->is_gym)
			$data['controlled_by'] = $this->gym_id;

		// Nuovo utente
		if($this->new) {
			// Genero una password di 8 caratteri che manderemo per mail
			$password = Str::random(8);
			$data['password'] = Hash::make($password);
			User::create($data);
			// Invio email con password\
			// Mail::to($this->email)->send(new UserCreated($this->email, $password));
		}
		// Modifica di utente già esistente
		elseif($this->modal_user) {
			$this->modal_user->update($data);
		}

		$this->show_details_modal = false;
	}

}
