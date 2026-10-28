<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /** Anyone can browse recipes and use cooking mode; adding, editing and deleting need an account. */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'cook']]);
    }

    /** Home: search, category filter, popular recipes and every recipe, newest first. */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category');
        if (! array_key_exists($category, Post::CATEGORIES)) {
            $category = null;
        }

        $base = Post::with('user')->withAvg('ratings', 'stars')->withCount('ratings');

        $posts = (clone $base)
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($q !== '', function ($query) use ($q) {
                $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $q) . '%';
                $query->where(function ($w) use ($like) {
                    $w->where('title', 'like', $like)
                      ->orWhere('ingredients', 'like', $like)
                      ->orWhere('category', 'like', $like);
                });
            })
            ->latest()
            ->get();

        // Popular: best rated first, then the newest. Only shown when not searching.
        $popular = ($q === '' && ! $category)
            ? (clone $base)->orderByDesc('ratings_avg_stars')->orderByDesc('ratings_count')->latest()->take(6)->get()
            : collect();

        return view('posts.index', [
            'posts' => $posts,
            'popular' => $popular,
            'q' => $q,
            'category' => $category,
            'savedIds' => $this->savedIds(),
        ]);
    }

    public function create()
    {
        return view('posts.create', ['post' => new Post(['category' => 'Lunch'])]);
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
        $post = Post::with('user')->withAvg('ratings', 'stars')->withCount('ratings')->findOrFail($id);

        $more = Post::withAvg('ratings', 'stars')
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->latest()->take(4)->get();

        return view('posts.show', [
            'post' => $post,
            'more' => $more,
            'myRating' => Auth::check() ? (int) $post->ratings()->where('user_id', Auth::id())->value('stars') : 0,
            'savedIds' => $this->savedIds(),
        ]);
    }

    /** Cooking mode: one step at a time, with a timer when a step mentions minutes. */
    public function cook($id)
    {
        $post = Post::findOrFail($id);
        $steps = array_map(function ($text) {
            return ['text' => $text, 'minutes' => Post::stepMinutes($text)];
        }, $post->steps());

        return view('posts.cook', ['post' => $post, 'steps' => $steps]);
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
            $post->photo_credit = null;
            $post->photo_credit_url = null;
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
        $post->savedBy()->detach();
        $post->ratings()->delete();
        $post->delete();

        return redirect('/home')->with('success', 'Recipe deleted!');
    }

    private function validateRecipe(Request $request, bool $imageRequired): array
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:120',
            'category' => ['required', Rule::in(array_keys(Post::CATEGORIES))],
            'preptime' => 'required|string|max:60',
            'servings' => 'nullable|integer|min:1|max:50',
            'difficulty' => ['nullable', Rule::in(Post::DIFFICULTIES)],
            'calories' => 'nullable|integer|min:0|max:5000',
            'image' => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp,gif|max:1999',
            'description' => 'required|string|max:2000',
            'ingredients' => 'required|string|max:5000',
            'preparation' => 'required|string|max:10000',
        ], [
            'image.max' => 'The photo must be 2 MB or smaller.',
        ]);
        unset($data['image']);

        return $data;
    }

    private function owns(Post $post): bool
    {
        return Auth::check() && (int) $post->user_id === (int) Auth::id();
    }

    private function savedIds(): array
    {
        return Auth::check() ? Auth::user()->savedRecipes()->pluck('posts.id')->all() : [];
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
