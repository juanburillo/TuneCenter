<?php

use App\Http\Controllers\AudioController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LyricController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

Route::get('/about', function() {
    return Inertia::render('About');
})->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('/projects/{project}', [ProjectController::class, 'showDashboard'])->name('projects.show.dashboard');
    Route::get('/projects/{project}/lyrics', [ProjectController::class, 'showLyrics'])->name('projects.show.lyrics');
    Route::get('/projects/{project}/audio', [ProjectController::class, 'showAudio'])->name('projects.show.audio');
    Route::get('/projects/{project}/messages', [ProjectController::class, 'showMessages'])->name('projects.show.messages');

    Route::post('/connections', [ConnectionController::class, 'store'])->name('connections.store');
    Route::get('/connections', [ConnectionController::class, 'index'])->name('connections.index');
    Route::put('/connections/{user}', [ConnectionController::class, 'update'])->name('connections.update');
    Route::delete('/connections/{user}', [ConnectionController::class, 'destroy'])->name('connections.destroy');

    Route::post('/invitations/{project}', [InvitationController::class, 'store'])->name('invitations.store');
    Route::put('/invitations/{project}', [InvitationController::class, 'update'])->name('invitations.update');
    Route::delete('/invitations/{project}', [InvitationController::class, 'destroy'])->name('invitations.destroy');

    Route::post('/lyrics', [LyricController::class, 'store'])->name('lyrics.store');
    Route::put('/lyrics/{lyric}', [LyricController::class, 'update'])->name('lyrics.update');
    Route::delete('/lyrics/{lyric}', [LyricController::class, 'destroy'])->name('lyrics.destroy');

    Route::post('/audio', [AudioController::class, 'store'])->name('audio.store');
});

require __DIR__.'/auth.php';
