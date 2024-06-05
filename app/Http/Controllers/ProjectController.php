<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStoreRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $validatedData['owner_id'] = auth()->id();

        $project = auth()->user()->projects()->create($validatedData);

        return redirect()->route('projects.show.dashboard', $project->id);
    }

    public function index(): Response
    {
        return Inertia::render('Projects/Index', [
            'projects' => auth()->user()->projects()->latest('updated_at')->get(),
            'invitations' => auth()->user()->projectInvitations()->orderBy('title')->get(),
        ]);
    }

    public function update(ProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        Gate::authorize('update', $project);
        $project->update($request->validated());

        return redirect()->route('projects.show.dashboard', $project->id);
    }

    public function destroy(Project $project): RedirectResponse
    {
        try {
            Gate::authorize('delete', $project);
            $project->delete();

            $message = 'Project deleted successfully!';
        } catch (AuthorizationException $exception) {
            $project->users()->detach(auth()->user());

            if ($project->users()->count() === 1) {
                $project->update(['is_collaborative' => false]);
            }

            $message = 'You left the project!';
        }

        return redirect()->route('projects.index')->with('success', $message);
    }

    public function showDashboard(Project $project): Response
    {
        Gate::authorize('view', $project);
        return Inertia::render('Projects/Dashboard', [
            'project' => auth()->user()->projects()->find($project),
            'connections' => auth()->user()->connections(),
            'collaborators' => $project->users,
        ]);
    }

    public function showLyrics(Project $project): Response
    {
        Gate::authorize('view', $project);
        return Inertia::render('Projects/Lyrics', [
            'project' => auth()->user()->projects()->find($project),
            'lyrics' => $project->lyrics()->latest()->get(),
        ]);
    }

    public function showAudio(Project $project): Response
    {
        Gate::authorize('view', $project);
        return Inertia::render('Projects/Audio', [
            'project' => auth()->user()->projects()->find($project),
            'audios' => $project->audio()->orderBy('type')->orderByDesc('created_at')->get(),
        ]);
    }

    public function showMessages(Project $project): Response
    {
        Gate::authorize('view', $project);
        return Inertia::render('Projects/Messages', [
            'project' => auth()->user()->projects()->find($project),
            'messages' => $project->messages,
        ]);
    }
}
