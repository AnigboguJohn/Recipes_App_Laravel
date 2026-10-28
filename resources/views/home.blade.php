@extends('layouts.app', ['tab' => 'profile'])
@section('title', 'Your profile')

@section('content')
    <section class="panel profile">
        <img class="avatar avatar-lg" src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
        <h1>{{ $user->name }}</h1>
        <p class="muted" style="margin:2px 0 0">{{ $user->email }}</p>
        <div class="tiles">
            <div class="tile"><b>{{ $posts->count() }}</b><small>{{ $posts->count() == 1 ? 'Recipe' : 'Recipes' }}</small></div>
            <div class="tile"><b>{{ $savedCount }}</b><small>Saved</small></div>
            <div class="tile"><b>{{ $ratingsCount ? '★ ' . number_format($ratingsAvg, 1) : '–' }}</b><small>{{ $ratingsCount }} {{ $ratingsCount == 1 ? 'rating' : 'ratings' }}</small></div>
        </div>
        <div class="form-actions" style="justify-content:center;margin-top:18px">
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-ghost btn-sm">@include('partials.icon', ['name' => 'edit']) Edit profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm">@include('partials.icon', ['name' => 'logout']) Log out</button>
            </form>
        </div>
    </section>

    <div class="section-head"><h2>My recipes</h2><a href="{{ route('posts.create') }}">+ Add recipe</a></div>
    @if ($posts->count())
        <div class="list">
            @foreach ($posts as $post)
                @php $avg = $post->averageRating(); @endphp
                <div class="row">
                    <a href="{{ route('posts.show', $post->id) }}"><img src="{{ $post->coverUrl() }}" alt="" loading="lazy"></a>
                    <a href="{{ route('posts.show', $post->id) }}" class="grow">
                        <h3>{{ $post->title }}</h3>
                        <div class="meta">
                            <span>@include('partials.icon', ['name' => 'clock']) {{ $post->preptime }}</span>
                            <span>{{ $avg ? '★ ' . number_format($avg, 1) : 'No ratings yet' }}</span>
                        </div>
                    </a>
                    <a href="{{ route('posts.edit', $post->id) }}" class="icon-btn" aria-label="Edit {{ $post->title }}">@include('partials.icon', ['name' => 'edit'])</a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty">
            <b>👩🏾‍🍳</b>
            <p>You haven't posted a recipe yet.</p>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Add your first recipe</a>
        </div>
    @endif
@endsection
