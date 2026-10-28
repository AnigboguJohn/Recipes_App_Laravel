@extends('layouts.app', ['tab' => 'add'])
@section('title', 'Add a recipe')

@section('content')
    <h1 class="page-title">Add a recipe</h1>
    <p class="muted" style="margin-top:0">Share a dish you love. Proofread it so nobody misses an ingredient.</p>

    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="panel" style="margin-top:18px">
        @csrf
        @include('posts._form')
        <div class="form-actions" style="margin-top:22px">
            <button type="submit" class="btn btn-primary">Add recipe</button>
            <a href="{{ url('/') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
@endsection
