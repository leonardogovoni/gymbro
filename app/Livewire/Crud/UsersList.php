<?php

namespace App\Livewire\Crud;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class UsersList extends Component
{
    use WithPagination;

    public $search_parameter;

    public function render()
    {
        $results = User::where('first_name', 'like', "%{$this->search_parameter}%")
            ->orWhere('last_name', 'like', "%{$this->search_parameter}%")
            ->orWhere('email', 'like', "%{$this->search_parameter}%")
            ->paginate(20);

        return view('livewire.crud.users_list', [
            'results' => $results
        ]);
    }
}
