<?php

namespace App\Http\Livewire\Pathway;

use Auth;
use Mail;
use App\Models\User;
use App\Models\Pathway;
use Livewire\Component;
use App\Models\Assignment;
use App\Mail\AssignedToPathway;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AssignPathway extends Component
{
    use LivewireAlert;

    # Data
    public $users = [];

    # Props
    public $pathway_id;
    public $assign_users = [];

    protected $rules = [
        'assign_users' => 'required_without_all'
    ];

    public function render()
    {
        return view('livewire.pathway.assign-pathway');
    }

    public function mount($pathwayId)
    {
        $this->pathway_id = $pathwayId;
        $this->users = User::get();

        $ids = Assignment::where('assignmentable_id', $pathwayId)->pluck('user_id')->all();

        $this->assign_users = $ids;
    }

    public function assign()
    {
        $this->validate();

        foreach($this->assign_users as $userId)
        {
            $user = User::find($userId);

            $assignment = Assignment::create([
                'user_id' => $userId,
                'assignmentable_id' => $this->pathway_id,
                'assignmentable_type' => Pathway::class,
                'assigned_by' => Auth::id()
            ]);

            Mail::to($assignment->user->email)->send(new AssignedToPathway($assignment));
        }

        $this->alert('success', 'Assignment sent!');

        $this->dispatchBrowserEvent('closemodal-assign-pathway-' . $this->pathway_id);
    }
    
}
