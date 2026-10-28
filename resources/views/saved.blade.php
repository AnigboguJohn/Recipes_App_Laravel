@extends('layouts.app', ['tab' => 'saved'])
@section('title', 'Saved recipes')

@section('content')
    <h1 class="page-title">Saved recipes</h1>
    <p class="muted" style="margin-top:0">Tap the ❤ on any recipe to keep it here.</p>

    @if ($posts->count())
        <div class="list" style="margin-top:18px">
            @foreach ($posts as $post)
                @php $avg = $post->averageRating(); @endphp
                <a href="{{ route('posts.show', $post->id) }}" class="row">
                    <img src="{{ $post->coverUrl() }}" alt="" loading="lazy">
                    <div class="grow">
                        <h3>{{ $post->title }}</h3>
                        <div class="meta">
                            <span>@include('partials.icon', ['name' => 'clock']) {{ $post->preptime }}</span>
                            @if ($avg)<span><b class="star">★</b> {{ number_format($avg, 1) }}</span>@endif
                            <span>{{ $post->categoryIcon() }} {{ $post->category }}</span>
                        </div>
                    </div>
                    <span class="chev">@include('partials.icon', ['name' => 'next'])</span>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty" style="margin-top:18px">
            <b>🤍</b>
            <p>No saved recipes yet.</p>
            <a href="{{ url('/') }}" class="btn btn-primary">Find something to cook</a>
        </div>
    @endif
@endsection
