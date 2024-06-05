<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {

        $validatedData = $request->validate([
            'username' => 'required|string',
        ]);

        $recipient = User::where('username', $validatedData['username'])->first();

         // Check if the recipient user exists
        if (! $recipient) return back()->withErrors(['username' => 'This user does not exist.']);

        // Check if the recipient user is a connection
        if (! auth()->user()->connections()->find($recipient)) {
            return back()->withErrors(['username' => 'You can only invite your connections.']);
        }

        // Check if the recipient user is already in the project
        if ($project->users()->find($recipient)) return back()->withErrors(['username' => 'This user is already in the project.']);

        // Check if the recipient user has already been invited to the project.
        if ($project->invitedUsers()->find($recipient)) return back()->withErrors(['username' => 'This user has already been invited to this project.']);

        $project->invitedUsers()->attach($recipient);

        return back()->with('success', 'Invitation sent successfully!');
    }

    public function update(Project $project): RedirectResponse
    {
        $project->users()->attach(auth()->user());

        $project->invitedUsers()->detach(auth()->user());

        if (! $project->is_collaborative) $project->update(['is_collaborative' => true]);

        return back()->with('success', 'You joined the project!');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->invitedUsers()->detach(auth()->user());

        return back()->with('success', 'Project invitation declined!');
    }
}
