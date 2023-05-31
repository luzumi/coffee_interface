<?php

namespace App\Http\Livewire;

use App\Models\CoffeeVariety;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class CatTable extends Component
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
        $cats = CoffeeVariety::query();

        if ($this->sortField !== null) {
            $cats = $cats->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        }

        $cats = $cats->paginate(10);

        return view('livewire.cat-table', ['cats' => $cats]);
    }
}
