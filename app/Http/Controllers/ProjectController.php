<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $project = Project::create($validatedData);

        return $project;
    }
}
