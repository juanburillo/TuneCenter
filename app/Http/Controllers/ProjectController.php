<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request)
    {
        return Project::create($request->validated());
    }

    public function index() {
        return Inertia::render('Projects/Index');
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        return $project->update($request->validated());
    }

    public function destroy(Project $project) {
        return $project->delete();
    }
}
