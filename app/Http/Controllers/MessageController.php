<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function store(MessageStoreRequest $request): void
    {
        auth()->user()->messages()->create($request->validated());
    }
}
