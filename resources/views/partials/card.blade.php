{{-- Recipe card for grids. --}}
@php $avg = $post->averageRating(); @endphp
<article class="card">
    @include('partials.heart', ['post' => $post])
    <a href="{{ route('posts.show', $post->id) }}" class="card-img">
        <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" loading="lazy">
    </a>
    <a href="{{ route('posts.show', $post->id) }}" class="card-body">
        <h3>{{ $post->title }}</h3>
        <div class="meta">
            <span>@include('partials.icon', ['name' => 'clock']) {{ $post->preptime }}</span>
            @if ($avg)<span><b class="star">★</b> {{ number_format($avg, 1) }}</span>@endif
            @if ($post->calories)<span>@include('partials.icon', ['name' => 'flame']) {{ $post->calories }} kcal</span>@endif
        </div>
        <div class="meta">{{ $post->categoryIcon() }} {{ $post->category }}</div>
    </a>
</article>
