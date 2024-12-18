<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // this is the controller for the auth
        // uses the auth middleware
        // later we will create a laravel API
        // we will understand more about middleware there
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
      
       //we get the id of that user
       // the one that is currently logged in
        $userId = Auth()->user()->id;
        //we get his ID
        $user = User::find($userId);
        //and we now can access the posts related to that ID
        // remember again, the posts have now a column called
        // user_id
        //that is the key used to manage the posts of that user
        return view('home')->with("posts", $user->posts);
    }



}
