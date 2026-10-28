<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /** Recipes this user posted. */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /** Recipes this user saved. */
    public function savedRecipes()
    {
        return $this->belongsToMany('App\Post', 'favorites')->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function firstName(): string
    {
        return strtok($this->name, ' ') ?: $this->name;
    }

    public function avatarUrl(): string
    {
        return $this->avatar && $this->avatar !== 'default.png'
            ? asset('storage/avatars/' . rawurlencode($this->avatar))
            : asset('images/default.png');
    }
}
