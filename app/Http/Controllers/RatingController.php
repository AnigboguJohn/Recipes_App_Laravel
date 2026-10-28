<?php

namespace App\Http\Controllers;

use App\Post;
use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Rate a recipe from 1 to 5 stars. Rating again replaces your earlier rating. */
    public function store(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if ((int) $post->user_id === (int) Auth::id()) {
            return back()->with('error', "You can't rate your own recipe.");
        }

        $data = $this->validate($request, ['stars' => 'required|integer|min:1|max:5']);
        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'post_id' => $post->id],
            ['stars' => $data['stars']]
        );

        return redirect('/posts/' . $post->id . '#rate')->with('success', 'Thanks for rating!');
    }
}
