<?php

namespace App\Models;

use App\Helpers\Loggable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Overtrue\LaravelFavorite\Traits\Favoriter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail, HasMedia
{
    use HasApiTokens, Notifiable, MustVerifyEmail, InteractsWithMedia, Loggable, SoftDeletes, Favoriter, HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'phone',
        'banned_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['favorites'];

    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->last_name;
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getBackendLinkAttribute(): string
    {
        return route('backend.users.edit', $this);
    }
}
