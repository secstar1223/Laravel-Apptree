<?php

namespace App\Http\Livewire\Pathway;

use App\Models\Pathway;
use Livewire\Component;

class ShowPathway extends Component
{
    public Pathway $pathway;

    public function render()
    {
        return view('livewire.pathway.show-pathway');
    }

    public function mount($id)
    {
        $this->pathway = Pathway::with('courses', 'goal')->withCount('courses')->findOrFail($id);
    }
}
