<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Profile: my recipes and a few numbers about them. */
    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts()->withAvg('ratings', 'stars')->latest()->get();
        $received = Rating::whereIn('post_id', $posts->pluck('id'));

        return view('home', [
            'user' => $user,
            'posts' => $posts,
            'savedCount' => $user->savedRecipes()->count(),
            'ratingsCount' => (clone $received)->count(),
            'ratingsAvg' => round((float) (clone $received)->avg('stars'), 1),
        ]);
    }
}
