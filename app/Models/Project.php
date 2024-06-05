<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'key',
        'time_signature',
        'bpm',
        'is_collaborative',
        'owner_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invitedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'invitations')->withTimestamps();
    }

    public function lyrics(): HasMany
    {
        return $this->hasMany(Lyric::class);
    }

    public function audio(): HasMany
    {
        return $this->hasMany(Audio::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
