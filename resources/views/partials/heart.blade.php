{{-- Save button. Works as a normal form; recipes.js upgrades it to save without reloading. --}}
@php $isSaved = in_array($post->id, $savedIds ?? []); @endphp
@auth
    <form method="POST" action="{{ route('posts.save', $post->id) }}" class="save-form">
        @csrf
        <button type="submit" class="heart {{ $isSaved ? 'on' : '' }} {{ $class ?? '' }}" aria-pressed="{{ $isSaved ? 'true' : 'false' }}" aria-label="{{ $isSaved ? 'Remove from saved' : 'Save recipe' }}">
            @include('partials.icon', ['name' => 'heart'])
        </button>
    </form>
@else
    <a href="{{ route('login') }}" class="heart {{ $class ?? '' }}" aria-label="Log in to save recipes">@include('partials.icon', ['name' => 'heart'])</a>
@endauth
