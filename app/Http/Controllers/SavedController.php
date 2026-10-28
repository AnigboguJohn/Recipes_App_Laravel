<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Recipes I saved, most recently saved first. */
    public function index()
    {
        $posts = Auth::user()->savedRecipes()->withAvg('ratings', 'stars')->orderByDesc('favorites.created_at')->get();

        return view('saved', ['posts' => $posts]);
    }

    /** Save or unsave a recipe. Answers JSON for the heart button, or redirects back without JavaScript. */
    public function toggle(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $result = Auth::user()->savedRecipes()->toggle($post->id);
        $saved = count($result['attached']) > 0;

        if ($request->expectsJson()) {
            return response()->json(['saved' => $saved]);
        }

        return back()->with('success', $saved ? 'Recipe saved.' : 'Removed from saved.');
    }
}
