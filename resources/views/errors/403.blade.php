@extends('layouts.app')
@section('title', 'Not allowed')

@section('content')
    <div class="empty" style="margin-top:30px">
        <b>🔒</b>
        <h1 style="font-size:26px;color:var(--ink)">Not allowed</h1>
        <p>That page belongs to someone else.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Back to recipes</a>
    </div>
@endsection
