@extends('layouts.app')
@section('title', 'Forgot password')

@section('content')
    <div class="auth">
        <div class="auth-card panel">
            <h1>Forgot password 🔑</h1>
            <p class="lead">Enter your email and we'll send you a link to choose a new password.</p>

            <form method="POST" action="{{ route('password.email') }}" class="form">
                @csrf
                <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Send reset link</button>
            </form>
            <p class="auth-foot"><a href="{{ route('login') }}">Back to log in</a></p>
        </div>
    </div>
@endsection
