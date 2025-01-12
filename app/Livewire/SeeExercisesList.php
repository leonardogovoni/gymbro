<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Exercise;

class SeeExercisesList extends Component
{
	public $exercise;
	public $categories;
	public $search_parameter;
	public $category_parameter;

	// Executed only when component is created
	public function mount()
	{
		$this->categories = Exercise::orderBy('muscle')->distinct()->pluck('muscle');
	}

	public function render()
	{
		if(is_null($this->category_parameter) || $this->category_parameter == 'all')
			$result = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')->get();
		else
			$result = Exercise::where('name', 'like', '%'.$this->search_parameter.'%')
						->where('muscle', '=', $this->categories[$this->category_parameter])
						->get();

		return view('livewire.see-exercises-list', [
			'results' => $result,
			'categories' => $this->categories
		]);
	}
}
