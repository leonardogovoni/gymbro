<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Exercise;

class SearchExercises extends Component
{
    public $search = '';
    public $categories =  ['muscolo 1', 'muscolo 2'];

    public function render()
    {
        return view('livewire.search-exercises', [
            'results' => Exercise::where('name', 'like', '%'.$this->search.'%')->get(),
            'categories' => $this->categories
        ]);
    }
}
