<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // we already have a User Model since the set up of the app
    // the only thing we do here by now, is the next
    use Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // avatar is not needed in fillable, but we can have it there
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     // if I already did this, sorry
     // as I said, there is a lot of code
     // custom code   
    
     //we create a function that tells laravel to create
    // a relationship between this and the Post Model
    // this says:
    // a USER can have MANY POSTS    
    public function posts(){
        return $this->hasMany("App\Post");
    }
}
