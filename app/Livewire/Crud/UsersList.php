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

    public $new = false;
    public $edit = false;
    public $inspect = false;

    public $modal_user;
    public $showDetailsModal = false;

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

    public function delete($id)
    {
        // DA CONTROLLARE, ma quando cancello un utente
        // con schede dovrebbe eliminarle già così
        User::find($id)->delete();
    }

    public function create()
    {
        $this->modal_user = null;

        $this->new = true;
        $this->edit = false;
        $this->inspect = false;
        $this->showDetailsModal = true;
    }

    // Calling it inspect breaks the code
    public function inspectUser($id)
    {
        $this->modal_user = User::find($id);

        $this->new = false;
        $this->edit = false;
        $this->inspect = true;
        $this->showDetailsModal = true;
    }
}
