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

    public function render(): Factory|View|Application
    {
        $rfids = RFID_Tag::query()->with('user');

        if ($this->sortField !== null) {
            $rfids = $rfids->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        if ($this->search !== '') {
            $rfids = $rfids->where('tag_uid', 'like', '%' . $this->search . '%')
                ->orWhere('role', 'like', '%' . $this->search . '%')
                ->orWhere('tag_active', 'like', '%' . $this->search . '%')
                ->orWhereHas('user', function ($query) {
                    $query->where('username', 'like', '%' . $this->search . '%');
                });
        }

        $rfids = $rfids->paginate(100);

        return view('livewire.rfid-table', ['rfids' => $rfids]);
    }
}
