<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionStoreRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConnectionController extends Controller
{
    public function store(ConnectionStoreRequest $request): RedirectResponse
    {
        $request->validated();

        $recipient = User::where('username', $request['username'])->first();

        // Check if the recipient user exists
        if (! $recipient) {
            return back()->withErrors(['username' => 'This user does not exist.']);
        }

        // Check if the recipient is the authenticated user
        if ($recipient->is(auth()->user())) {
            return back()->withErrors(['username' => 'You cannot add yourself.']);
        }

        // Check if the users are already connected to each other
        if (auth()->user()->connections()->find($recipient)) {
            return back()->withErrors(['username' => 'You are already connected to this user.']);
        }

        // Check if the connection request has already been sent
        if (auth()->user()->pendingSentConnections()->find($recipient)) {
            return back()->withErrors(['username' => 'You have already sent a connection request to this user.']);
        }

        // Check if there's already a pending connection request from the recipient
        if (auth()->user()->pendingReceivedConnections()->find($recipient)) {
            return back()->withErrors(['username' => 'You have already received a connection request from this user.']);
        }

        auth()->user()->pendingSentConnections()->attach($recipient);

        return back()->with('success', 'Connection request successfully sent!');
    }

    public function index(): Response
    {
        return Inertia::render('Connections/Index', [
            'connections' => auth()->user()->connections()->sortBy('username'),
            'incomingRequests' => auth()->user()->pendingReceivedConnections,
        ]);
    }

    public function update(User $user): RedirectResponse
    {
        auth()->user()->pendingReceivedConnections()->updateExistingPivot($user, ['accepted' => true]);

        return back()->with('success', 'Connection request accepted!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->user()->pendingReceivedConnections()->detach($user)) {
            // Connection request has been declined
            $message = 'Connection request declined!';
        } else {
            // Connection has been removed
            auth()->user()->acceptedReceivedConnections()->detach($user) || auth()->user()->acceptedSentConnections()->detach($user);
            $message = 'Connection removed!';
        }

        return back()->with('success', $message);
    }
}
