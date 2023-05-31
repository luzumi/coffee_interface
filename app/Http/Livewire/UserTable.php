<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserTable extends Component
{
    use WithPagination;

    public $sortField;
    public $sortAsc = true;
    public $search = '';


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $users = User::query();

        if ($this->sortField !== null) {
            $users = $users->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->search !== '') {
            $users = $users->where('username', 'like', '%' . $this->search . '%')
                ->orWhere('firstname', 'like', '%' . $this->search . '%')
                ->orWhere('lastname', 'like', '%' . $this->search . '%');
            // Fügen Sie hier zusätzliche Felder hinzu, nach denen gesucht werden soll
        }

        $users = $users->paginate(10);

        return view('livewire.user-table', ['users' => $users]);
    }

}
