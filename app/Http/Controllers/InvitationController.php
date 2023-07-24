<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamInvitation;
use Laravel\Jetstream\Jetstream;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Jetstream\AddTeamMember;
use Laravel\Jetstream\Contracts\AddsTeamMembers;

class InvitationController extends Controller
{
    public function accept(Request $request, $invitationId)
    {
        $model = Jetstream::teamInvitationModel();

        $invitation = $model::whereKey($invitationId)->firstOrFail();
        
        if($this->userDoesNotExist($invitation->email))
        {
            return view('auth.register-invitation', compact('invitation'));
        }

        app(AddsTeamMembers::class)->add(
            $invitation->team->owner,
            $invitation->team,
            $invitation->email,
            $invitation->role
        );

        $invitation->delete();

        return redirect(config('fortify.home'))->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        );
    }

    private function userDoesNotExist($email)
    {
        return User::where('email', $email)->first() ? false : true;
    }

    public function  register(Request $request, $invitationId)
    {
        $invitation = TeamInvitation::findOrFail($invitationId);

        $validated = $request->validate([
            'email' => 'required|email',
            'name' => 'required|min:2|max:191',
            'password' => 'required|min:5|max:191|confirmed'
        ]);

        # User
        $user = $this->createUser($validated);

        # Team
        $team = $invitation->team;

        $team->users()->attach(
            $user, ['role' => $invitation->role]
        );

        $invitation->delete();

        // TODO: Auth/login doesn't work
        Auth::login($user);

        return redirect('/dashboard')->banner(
            __('Great! You have accepted the invitation to join the :team team.', ['team' => $invitation->team->name]),
        );
    }

    private function createUser($data)
    {
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->email_verified_at = now();
        $user->save();

        $user->assignRole('learner');

        $this->createTeam($user);

        return $user;
    }

    private function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}
