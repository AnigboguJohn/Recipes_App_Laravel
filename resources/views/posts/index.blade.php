@extends('layouts.app', ['tab' => 'home'])
@section('title', $category ?: ($q ? 'Search' : 'Recipes'))

@section('content')
    <section class="hello">
        <p>Hello, {{ Auth::check() ? Auth::user()->firstName() : 'there' }} 👋</p>
        <h1>What do you want to cook <span class="accent">today?</span></h1>

        <form class="search" action="{{ url('/') }}" method="GET" role="search">
            @include('partials.icon', ['name' => 'search'])
            <label for="q" class="sr-only">Search recipes</label>
            <input id="q" name="q" type="search" value="{{ $q }}" placeholder="Search recipes or ingredients…" autocomplete="off">
            @if ($category)<input type="hidden" name="category" value="{{ $category }}">@endif
            <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <nav class="chips" aria-label="Categories">
            <a href="{{ url('/') . ($q ? '?q=' . urlencode($q) : '') }}" class="chip {{ ! $category ? 'on' : '' }}"><span>✨</span>All</a>
            @foreach (\App\Post::CATEGORIES as $name => $icon)
                <a href="{{ url('/') . '?category=' . urlencode($name) . ($q ? '&q=' . urlencode($q) : '') }}" class="chip {{ $category === $name ? 'on' : '' }}" aria-current="{{ $category === $name ? 'page' : 'false' }}"><span>{{ $icon }}</span>{{ $name }}</a>
            @endforeach
        </nav>
    </section>

    @if ($popular->count())
        <div class="section-head"><h2>Popular recipes</h2></div>
        <div class="rail">
            @foreach ($popular as $post)
                @php $avg = $post->averageRating(); @endphp
                <article class="tall">
                    @include('partials.heart', ['post' => $post])
                    <span class="badge badge-tl">@include('partials.icon', ['name' => 'clock']) {{ $post->preptime }}</span>
                    <a href="{{ route('posts.show', $post->id) }}">
                        <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" loading="lazy">
                        <div class="tall-body">
                            <h3>{{ $post->title }}</h3>
                            <p>{{ $post->category }}@if ($avg) · ★ {{ number_format($avg, 1) }}@endif</p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    @endif

    <div class="section-head">
        <h2>
            @if ($q) Results for “{{ $q }}”{{ $category ? ' in ' . $category : '' }}
            @elseif ($category) {{ $category }}
            @else All recipes
            @endif
            <span class="muted" style="font-weight:400;font-size:15px">({{ $posts->count() }})</span>
        </h2>
        @if ($q || $category)<a href="{{ url('/') }}">Clear</a>@endif
    </div>

    @if ($posts->count())
        <div class="grid">
            @foreach ($posts as $post)
                @include('partials.card', ['post' => $post])
            @endforeach
        </div>
    @else
        <div class="empty">
            <b>🥘</b>
            <p>No recipes found{{ $q ? ' for “' . $q . '”' : '' }}.</p>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Add a recipe</a>
        </div>
    @endif
@endsection
