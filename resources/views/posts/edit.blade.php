@extends('layouts.app', ['tab' => 'profile'])
@section('title', 'Edit ' . $post->title)

@section('content')
    <h1 class="page-title">Edit recipe</h1>
    <p class="muted" style="margin-top:0">{{ $post->title }}</p>

    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="panel" style="margin-top:18px">
        @csrf
        @method('PUT')
        @include('posts._form')
        <div class="form-actions" style="margin-top:22px">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>

    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="delete" style="margin-top:18px" onsubmit="return confirm('Delete this recipe? This cannot be undone.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">@include('partials.icon', ['name' => 'trash']) Delete this recipe</button>
    </form>
@endsection
