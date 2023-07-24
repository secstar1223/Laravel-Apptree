<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalXl extends Component
{
    public $ref;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ref)
    {
        $this->ref = $ref;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-xl');
    }
}
