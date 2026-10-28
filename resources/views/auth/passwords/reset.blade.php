@extends('layouts.app')
@section('title', 'Choose a new password')

@section('content')
    <div class="auth">
        <div class="auth-card panel">
            <h1>New password</h1>
            <p class="lead">Choose a new password for your account.</p>

            <form method="POST" action="{{ route('password.update') }}" class="form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ $email ?? old('email', request('email')) }}" required autocomplete="email">
                </div>
                <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                    <label for="password">New password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" minlength="6">
                </div>
                <div class="field">
                    <label for="password-confirm">Confirm new password</label>
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Save new password</button>
            </form>
        </div>
    </div>
@endsection
