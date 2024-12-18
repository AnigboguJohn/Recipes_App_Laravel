<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

   // time to add something to our Post Model 
   public function user(){
        // we do the same here
        // just saying a post belongs to a user
        // that way the relationship
        //between the 2 tables is created
        return $this->belongsTo('App\User');
   }
}


