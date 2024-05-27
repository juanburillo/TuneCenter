<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request): Project
    {
        $validatedData = $request->validated();

        $validatedData['owner_id'] = auth()->id();

        return Project::create($validatedData);
    }

    public function index(): Response
    {
        return Inertia::render('Projects/Index');
    }

    public function show(): Response
    {
        return Inertia::render('Projects/Show');
    }

    public function update(UpdateProjectRequest $request, Project $project): bool
    {
        return $project->update($request->validated());
    }

    public function destroy(Project $project): bool
    {
        return $project->delete();
    }
}
