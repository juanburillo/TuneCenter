<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function ownedProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    // Connection relationships
    public function connections(): Collection
    {
        return $this->acceptedSentConnections->merge($this->acceptedReceivedConnections);
    }

    public function allSentConnections(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'connections', 'sender_id', 'recipient_id')->withTimestamps();
    }

    public function allReceivedConnections(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'connections', 'recipient_id', 'sender_id')->withTimestamps();
    }

    public function pendingSentConnections(): BelongsToMany
    {
        return $this->allSentConnections()->wherePivot('accepted', false);
    }

    public function pendingReceivedConnections(): BelongsToMany
    {
        return $this->allReceivedConnections()->wherePivot('accepted', false);
    }

    public function acceptedSentConnections(): BelongsToMany
    {
        return $this->allSentConnections()->wherePivot('accepted', true);
    }

    public function acceptedReceivedConnections(): BelongsToMany
    {
        return $this->allReceivedConnections()->wherePivot('accepted', true);
    }
}
