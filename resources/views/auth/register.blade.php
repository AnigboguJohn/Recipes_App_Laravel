@extends('layouts.app')
@section('title', 'Create an account')

@section('content')
    <div class="auth">
        <div class="auth-card panel">
            <h1>Create an account</h1>
            <p class="lead">Post your own recipes and keep your favourites.</p>

            <form method="POST" action="{{ route('register') }}" class="form">
                @csrf
                <div class="field {{ $errors->has('name') ? 'error' : '' }}">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" maxlength="255">
                </div>
                <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" maxlength="255">
                </div>
                <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                    <label for="password">Password <small>(at least 6 characters)</small></label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" minlength="6">
                </div>
                <div class="field">
                    <label for="password-confirm">Confirm password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign up</button>
            </form>
            <p class="auth-foot">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </div>
    </div>
@endsection
