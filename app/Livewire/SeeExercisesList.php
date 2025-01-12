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
        $query = Exercise::query();

        // Filtra per categoria
        if (!is_null($this->category_parameter) && $this->category_parameter !== 'all') {
            $query->where('muscle', '=', $this->category_parameter);
        }

        // Filtra per nome
        if (!empty($this->search_parameter)) {
            $query->where('name', 'like', '%' . $this->search_parameter . '%');
        }

        $result = $query->get();

        return view('livewire.see-exercises-list', [
            'results' => $result,
            'categories' => $this->categories
        ]);
    }
}
