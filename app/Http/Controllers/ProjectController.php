<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;

class ProjectController extends Controller
{
    public function store(StoreProjectRequest $request)
    {
        return Project::create($request->validated());
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        return $project->update($request->validated());
    }
}
