<?php

namespace App\Http\Controllers;

use App\Http\Requests\LyricStoreRequest;
use App\Http\Requests\LyricUpdateRequest;
use App\Models\Lyric;
use Illuminate\Http\RedirectResponse;

class LyricController extends Controller
{
    public function store(LyricStoreRequest $request): RedirectResponse
    {
        auth()->user()->lyrics()->create($request->validated());

        return redirect()->back()->with('success', 'Lyric created successfully!');
    }

    public function update(LyricUpdateRequest $request, Lyric $lyric): RedirectResponse
    {
        $lyric->update($request->validated());

        return redirect()->back()->with('success', 'Lyric updated successfully!');
    }

    public function destroy(Lyric $lyric): RedirectResponse
    {
        $lyric->delete();

        return redirect()->back()->with('success', 'Lyric deleted successfully!');
    }
}
