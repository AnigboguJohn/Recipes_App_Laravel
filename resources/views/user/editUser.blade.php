@extends('layouts.app', ['tab' => 'profile'])
@section('title', 'Edit profile')

@section('content')
    <h1 class="page-title">Edit profile</h1>

    <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data" class="panel form" style="margin-top:18px;max-width:560px">
        @csrf
        @method('PUT')
        <div class="field {{ $errors->has('avatar') ? 'error' : '' }}" style="justify-items:center;text-align:center">
            <label for="avatar" style="cursor:pointer;display:grid;justify-items:center;gap:8px">
                <img class="avatar avatar-lg avatar-preview" src="{{ $user->avatarUrl() }}" alt="">
                <span class="link">Change photo</span>
            </label>
            <input id="avatar" type="file" name="avatar" accept="image/png,image/jpeg,image/webp,image/gif" class="sr-only">
            @error('avatar')<span class="err">{{ $message }}</span>@enderror
        </div>
        <div class="field {{ $errors->has('name') ? 'error' : '' }}">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name">
            @error('name')<span class="err">{{ $message }}</span>@enderror
        </div>
        <div class="field {{ $errors->has('email') ? 'error' : '' }}">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email">
            @error('email')<span class="err">{{ $message }}</span>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save profile</button>
            <a href="{{ route('home') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
@endsection
