<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function update(Project $project): RedirectResponse
    {
        $project->users()->attach(auth()->user());

        $project->invitedUsers()->detach(auth()->user());

        if (! $project->is_collaborative) $project->update(['is_collaborative' => true]);

        return redirect()->route('projects.index')->with('success', 'You joined the project!');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->invitedUsers()->detach(auth()->user());

        return redirect()->route('projects.index')->with('success', 'Project invitation declined!');
    }
}
