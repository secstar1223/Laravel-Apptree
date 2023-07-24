<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Pathway;
use Livewire\Component;

class ManagePathways extends Component
{
    # Data
    public $pathways = [];
    public $filter;

    public function render()
    {
        return view('livewire.pathway.manage-pathways');
    }

    public function mount()
    {
        $this->pathways = Pathway::withCount('courses')->get();
    }
}
