@extends('layouts.app', ['tab' => 'home'])
@section('title', $post->title)

@section('content')
    @php
        $avg = $post->averageRating();
        $ingredients = $post->ingredientList();
        $steps = $post->steps();
        $isOwner = Auth::check() && Auth::id() == $post->user_id;
    @endphp
    <div class="recipe-layout">
        <div class="recipe-hero">
            <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}">
            <div class="hero-actions">
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="icon-btn" aria-label="Back">@include('partials.icon', ['name' => 'back'])</a>
                @include('partials.heart', ['post' => $post])
            </div>
        </div>

        <article class="sheet">
            <div class="title-row">
                <div>
                    <h1>{{ $post->title }}</h1>
                    <div class="cat-label">{{ $post->categoryIcon() }} {{ $post->category }}</div>
                </div>
                @if ($avg)
                    <a href="#rate" class="rating-pill">★ {{ number_format($avg, 1) }} <small style="font-weight:500">({{ $post->ratings_count }})</small></a>
                @endif
            </div>

            <div class="stats">
                <div class="stat">@include('partials.icon', ['name' => 'clock'])<small>Cooking time</small><b>{{ $post->preptime }}</b></div>
                @if ($post->servings)<div class="stat">@include('partials.icon', ['name' => 'people'])<small>Servings</small><b>{{ $post->servings }} {{ $post->servings == 1 ? 'person' : 'people' }}</b></div>@endif
                @if ($post->difficulty)<div class="stat">@include('partials.icon', ['name' => 'chart'])<small>Difficulty</small><b>{{ $post->difficulty }}</b></div>@endif
                @if ($post->calories)<div class="stat">@include('partials.icon', ['name' => 'flame'])<small>Calories</small><b>{{ $post->calories }} kcal</b></div>@endif
            </div>

            <p class="lead" style="margin:0 0 18px">{{ $post->description }}</p>

            <div class="chef">
                <img class="avatar" src="{{ optional($post->user)->avatarUrl() ?? asset('images/default.png') }}" alt="">
                <div><small>Recipe by</small><b>{{ optional($post->user)->name ?? 'Unknown' }}</b></div>
            </div>

            <section class="block">
                <h2>Ingredients ({{ count($ingredients) }}) @if ($post->servings)<small>{{ $post->servings }} servings</small>@endif</h2>
                <ul class="ingredients">
                    @foreach ($ingredients as $item)<li>{{ $item }}</li>@endforeach
                </ul>
            </section>

            <section class="block">
                <h2>Steps ({{ count($steps) }})</h2>
                <ol class="steps">
                    @foreach ($steps as $step)<li>{{ $step }}</li>@endforeach
                </ol>
            </section>

            <div class="cook-bar">
                <a href="{{ route('posts.cook', $post->id) }}" class="btn btn-primary btn-block">@include('partials.icon', ['name' => 'play']) Start cooking</a>
            </div>

            <section class="block" id="rate">
                <h2>Rate this recipe</h2>
                <div class="rate-box">
                    @if ($avg)
                        <p style="margin:0"><b style="font-size:26px">★ {{ number_format($avg, 1) }}</b> <span class="muted">from {{ $post->ratings_count }} {{ $post->ratings_count == 1 ? 'rating' : 'ratings' }}</span></p>
                    @else
                        <p class="muted" style="margin:0">No ratings yet. Be the first to rate it.</p>
                    @endif

                    @auth
                        @if ($isOwner)
                            <p class="muted">This is your recipe, so others rate it.</p>
                        @else
                            <form method="POST" action="{{ route('posts.rate', $post->id) }}">
                                @csrf
                                <fieldset style="border:0;padding:0;margin:0">
                                    <legend class="sr-only">Your rating</legend>
                                    <div class="stars-input">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="stars" value="{{ $i }}" {{ $myRating == $i ? 'checked' : '' }} required>
                                            <label for="star{{ $i }}" title="{{ $i }} {{ $i == 1 ? 'star' : 'stars' }}">★<span class="sr-only">{{ $i }} {{ $i == 1 ? 'star' : 'stars' }}</span></label>
                                        @endfor
                                    </div>
                                </fieldset>
                                <button class="btn btn-dark" type="submit">{{ $myRating ? 'Update my rating' : 'Rate recipe' }}</button>
                            </form>
                        @endif
                    @else
                        <p><a href="{{ route('login') }}" class="link">Log in</a> to rate this recipe.</p>
                    @endauth
                </div>
            </section>

            @if ($isOwner)
                <section class="block owner">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-ghost">@include('partials.icon', ['name' => 'edit']) Edit recipe</a>
                </section>
            @endif

            @if ($post->photo_credit)
                <p class="credit">Photo: <a href="{{ $post->photo_credit_url }}" target="_blank" rel="noopener">{{ $post->photo_credit }}</a></p>
            @endif
        </article>
    </div>

    @if ($more->count())
        <div class="section-head"><h2>More {{ strtolower($post->category) }}</h2><a href="{{ url('/') . '?category=' . urlencode($post->category) }}">See all</a></div>
        <div class="grid">
            @foreach ($more as $item)
                @include('partials.card', ['post' => $item])
            @endforeach
        </div>
    @endif
@endsection
