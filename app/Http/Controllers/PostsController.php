<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /** Anyone can browse recipes; adding, editing and deleting need an account. */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /** All recipes, newest first. */
    public function index()
    {
        $posts = Post::with('user')->latest()->get();

        return view('posts.index')->with('posts', $posts);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateRecipe($request, true);

        $post = new Post;
        $post->fill($data);
        $post->cover = $this->storeCover($request);
        $post->user_id = Auth::id();
        $post->save();

        return redirect('/posts/' . $post->id)->with('success', 'Recipe added!');
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);

        return view('posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (! $this->owns($post)) {
            return redirect('/')->with('error', 'You can only edit your own recipes.');
        }

        return view('posts.edit')->with('post', $post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (! $this->owns($post)) {
            return redirect('/')->with('error', 'You can only edit your own recipes.');
        }

        $data = $this->validateRecipe($request, false);
        $post->fill($data);

        // A new photo replaces the old one. The old file name comes from the database,
        // never from the form, so a crafted request can't delete other files.
        if ($request->hasFile('image')) {
            $this->deleteCover($post->cover);
            $post->cover = $this->storeCover($request);
        }
        $post->save();

        return redirect('/posts/' . $post->id)->with('success', 'Recipe updated!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if (! $this->owns($post)) {
            return redirect('/')->with('error', 'You can only delete your own recipes.');
        }

        $this->deleteCover($post->cover);
        $post->delete();

        return redirect('/posts')->with('success', 'Recipe deleted!');
    }

    private function validateRecipe(Request $request, bool $imageRequired): array
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:120',
            'preptime' => 'required|string|max:60',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp,gif|max:1999',
            'description' => 'required|string|max:2000',
            'ingredients' => 'required|string|max:5000',
            'preparation' => 'required|string|max:10000',
        ]);
        unset($data['image']);

        return $data;
    }

    private function owns(Post $post): bool
    {
        return Auth::check() && (int) $post->user_id === (int) Auth::id();
    }

    /** Saves the uploaded photo under storage/app/public/covers with a random name. */
    private function storeCover(Request $request): string
    {
        return basename($request->file('image')->store('covers', 'public'));
    }

    private function deleteCover(?string $file): void
    {
        if ($file && $file === basename($file)) {
            Storage::disk('public')->delete('covers/' . $file);
        }
    }
}
