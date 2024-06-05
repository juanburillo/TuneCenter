<?php

namespace App\Http\Controllers;

use App\Http\Requests\LyricStoreRequest;

class LyricController extends Controller
{
    public function store(LyricStoreRequest $request)
    {
        auth()->user()->lyrics()->create($request->validated());
    }
}
