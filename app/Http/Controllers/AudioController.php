<?php

namespace App\Http\Controllers;

use App\Http\Requests\AudioStoreRequest;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function store(AudioStoreRequest $request)
    {
        $request->validated();

        Storage::makeDirectory('public/audio');

        $filePath = $request->file('file')->store('audio', 'public');

        auth()->user()->audio()->create([
            'title' => $request->title,
            'file' => $filePath,
            'type' => $request->type,
            'project_id' => $request->project_id,
        ]);

        return redirect()->back()->with('success', 'Audio item created successfully!');
    }
}
