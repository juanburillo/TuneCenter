<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $validatedData['owner_id'] = auth()->id();

        auth()->user()->projects()->create($validatedData);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function index(): Response
    {
        return Inertia::render('Projects/Index', [
            'projects' => auth()->user()->projects()->latest('updated_at')->get(),
        ]);
    }

    public function show(Project $project): Response
    {
        Gate::authorize('view', $project);
        return Inertia::render('Projects/Show', [
            'project' => auth()->user()->projects()->find($project),
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): bool
    {
        Gate::authorize('update', $project);
        return $project->update($request->validated());
    }

    public function destroy(Project $project): RedirectResponse
    {
        Gate::authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
    }
}
