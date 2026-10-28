@extends('layouts.app')
@section('content')
    <section class="edit">
        <h2>Edit <span> {{ $user->name }} </span></h2>

        <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Username</label>
                <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="255">
            </div>
            <div class="form-group">
                <label for="avatar">Avatar</label>
                <input id="avatar" type="file" name="avatar" accept="image/png,image/jpeg,image/webp,image/gif">
            </div>
            <div class="form-group2">
                <p>You can change these settings at any time.</p>
                <div class="form-edit-meta">
                    <input type="submit" value="Save Profile">
                </div>
            </div>
        </form>
    </section>
@endsection
