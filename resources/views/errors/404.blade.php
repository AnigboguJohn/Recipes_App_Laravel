@extends('layouts.app')
@section('title', 'Page not found')

@section('content')
    <div class="empty" style="margin-top:30px">
        <b>🍳</b>
        <h1 style="font-size:26px;color:var(--ink)">Page not found</h1>
        <p>We couldn't find that recipe or page. It may have been deleted.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Back to recipes</a>
    </div>
@endsection
