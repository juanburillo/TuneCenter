<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageStoreRequest;

class MessageController extends Controller
{
    public function store(MessageStoreRequest $request): void
    {
        auth()->user()->messages()->create($request->validated());
    }
}
