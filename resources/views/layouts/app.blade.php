<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@hasSection('title')@yield('title') · @endif My Recipes Book</title>
    <meta name="description" content="Share and cook Nigerian and home recipes: search, save, rate and cook step by step.">
    <meta name="theme-color" content="#faf6f0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><rect width='64' height='64' rx='16' fill='%23f0661c'/><text x='32' y='44' text-anchor='middle' font-size='34'>🍲</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/recipes.css') }}">
</head>
@php $tab = $tab ?? ''; @endphp
<body class="has-bottomnav">
    <header class="topbar">
        <div class="wrap topbar-in">
            <a href="{{ url('/') }}" class="brand"><span class="brand-mark">🍲</span> My Recipes Book</a>
            <nav class="toplinks" aria-label="Main">
                <a href="{{ url('/') }}" class="{{ $tab === 'home' ? 'on' : '' }}">Home</a>
                <a href="{{ route('saved') }}" class="{{ $tab === 'saved' ? 'on' : '' }}">Saved</a>
                <a href="{{ route('posts.create') }}" class="{{ $tab === 'add' ? 'on' : '' }}">Add recipe</a>
                @auth<a href="{{ route('home') }}" class="{{ $tab === 'profile' ? 'on' : '' }}">Profile</a>@endauth
            </nav>
            <div class="top-right">
                @auth
                    <a href="{{ route('home') }}" title="Your profile"><img class="avatar" src="{{ Auth::user()->avatarUrl() }}" alt="{{ Auth::user()->name }}"></a>
                @else
                    <div class="auth-links">
                        <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Log in</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign up</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <main class="wrap">
        @include('partials.messages')
        @yield('content')
    </main>

    <footer class="footer">My Recipes Book · Made by John Anigbogu (codegunius)</footer>

    <nav class="bottomnav" aria-label="Main">
        <a href="{{ url('/') }}" class="{{ $tab === 'home' ? 'on' : '' }}" aria-label="Home">@include('partials.icon', ['name' => 'home'])</a>
        <a href="{{ route('saved') }}" class="{{ $tab === 'saved' ? 'on' : '' }}" aria-label="Saved recipes">@include('partials.icon', ['name' => 'heart'])</a>
        <a href="{{ route('posts.create') }}" class="add {{ $tab === 'add' ? 'on' : '' }}" aria-label="Add a recipe">@include('partials.icon', ['name' => 'plus'])</a>
        <a href="{{ route('home') }}" class="{{ $tab === 'profile' ? 'on' : '' }}" aria-label="Profile">@include('partials.icon', ['name' => 'user'])</a>
    </nav>

    <script src="{{ asset('js/recipes.js') }}" defer></script>
</body>
</html>
