@extends('layouts.app')
@section('title', 'Log in')

@section('content')
    <div class="auth">
        <div class="auth-card panel">
            <h1>Hello there 👋</h1>
            <p class="lead">Log in to save, rate and share recipes.</p>

            <div class="demo">
                <span>Just looking? Use the demo account<br><b>demo@recipes.test</b> / <b>demo12345</b></span>
                <button type="button" class="btn btn-primary btn-sm" id="useDemo">Use demo</button>
            </div>

            <form method="POST" action="{{ route('login') }}" class="form">
                @csrf
                <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>
                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap">
                    <label class="check"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me</label>
                    <a href="{{ route('password.request') }}" class="link">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </form>
            <p class="auth-foot">New here? <a href="{{ route('register') }}">Create an account</a></p>
        </div>
    </div>
@endsection
