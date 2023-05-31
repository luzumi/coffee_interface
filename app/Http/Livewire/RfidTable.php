<?php

namespace App\Http\Livewire;

use App\Models\RFID_Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class RfidTable extends Component
{
    use WithPagination;

    public $sortField;
    public $sortAsc = true;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render(): Factory|View|Application
    {
        $rfids = RFID_Tag::query();

        if ($this->sortField !== null) {
            if($this->sortField === 'username') {
                // If sorting by username, we need to join on the users table
                $rfids = $rfids->leftJoin('users', 'rfid_tags.user_id', '=', 'users.id')
                    ->select('rfid_tags.*', 'users.username as username')
                    ->orderBy('username', $this->sortAsc ? 'asc' : 'desc');
            } else {
                $rfids = $rfids->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
            }
        }

        $rfids = $rfids->paginate(100);

        return view('livewire.rfid-table', ['rfids' => $rfids]);
    }
}
