<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'preptime', 'description', 'ingredients', 'preparation'];

    /** A recipe belongs to the user who posted it. */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /** Public URL of the cover photo. */
    public function coverUrl(): string
    {
        return asset('storage/covers/' . rawurlencode($this->cover));
    }
}
