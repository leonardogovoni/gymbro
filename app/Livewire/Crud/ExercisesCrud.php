<?php

namespace App\Livewire\Crud;

use App\Models\Exercise;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class ExercisesCrud extends Component
{
	// In questo componente non effettuo controlli sui permessi, in
	// quanto l'accesso è consentito SOLO a admin e non puoi proprio
	// aprore la pagina se sei una palestra (controllo nel controller)

	use WithPagination;

	// Variabili per la gestione del modale
	public $new = false;
	public $modal_exercise;
	public $show_details_modal = false;

	// Variabili del modale
	#[Validate('required', message: 'Il campo Nome è obbligatorio.')]
	public $name;
	public $image;
	public $description;
	#[Validate('required', message: 'Il campo Categoria è obbligatorio.')]
	public $muscle;

	// Parametro di ricerca
	public $search_parameter;

	// Eseguita a ogni render
	public function render()
	{
		$results = Exercise::where('name', 'like', "%{$this->search_parameter}%")
			->orWhere('description', 'like', "%{$this->search_parameter}%")
			->orWhere('muscle', 'like', "%{$this->search_parameter}%")
			->paginate(20);

		return view('livewire.crud.exercises', [
			'results' => $results
		]);
	}

	public function delete($id)
	{
		Exercise::find($id)->delete();
	}

	public function create()
	{
		$this->new = true;
		$this->modal_exercise = null;

		// Resetto i campi del modale
		// Piccolo workaround per accedere ad una proprieta' di un oggetto usando la stringa, restringhe il numero di righe
		// ed e' anche piu' carino da leggere. Si puo' fare anche in JS.
		$exercise_data = [ 'name', 'image', 'description', 'muscle' ];
		foreach ($exercise_data as $field) {
			$this->$field = '';
		}

		$this->show_details_modal = true;
	}

	// Chiamarlo solo inspect rompe tutto
	public function inspectExercise($id)
	{
		$this->new = false;
		$this->modal_exercise = Exercise::find($id);

		// Carico i dati dell'esercizio nelle variabili del modale
		$exercise_data = [ 'name', 'image', 'description', 'muscle' ];
		foreach ($exercise_data as $field) {
			$this->$field = $this->modal_exercise->$field;
		}

		$this->show_details_modal = true;
	}

	public function save()
	{
		$this->validate();

		// Dovrei scrivere sto dizionario sia per la creazione che per la modifica
		$data = [
			'name' => $this->name,
			'image' => $this->image,
			'description' => $this->description,
			'muscle' => $this->muscle
		];

		// Nuovo esercuzui
		if ($this->new) {
			Exercise::create($data);
		}
		// Modifica di utente già esistente
		elseif ($this->modal_exercise) {
			$this->modal_exercise->update($data);
		}

		$this->show_details_modal = false;
	}

}
