@extends('layouts.app', ['tab' => 'home'])
@section('title', 'Cooking ' . $post->title)

@section('content')
    <noscript><style>.cook-step[hidden]{display:flex !important}.cook-nav,.timer button{display:none}</style></noscript>
    <div class="cook" id="cook" data-steps="{{ count($steps) }}">
        <div class="cook-top">
            <a href="{{ route('posts.show', $post->id) }}" class="icon-btn" aria-label="Back to the recipe">@include('partials.icon', ['name' => 'back'])</a>
            <h1>{{ $post->title }}</h1>
            <span style="width:44px"></span>
        </div>

        <p class="step-count" aria-live="polite"><span id="stepNow">Step 1</span> of {{ count($steps) }}</p>
        <div class="dots" aria-hidden="true">
            @foreach ($steps as $i => $s)<i class="{{ $i === 0 ? 'on' : '' }}"></i>@endforeach
        </div>

        @foreach ($steps as $i => $step)
            <section class="step-card cook-step" data-step="{{ $i }}" {{ $i > 0 ? 'hidden' : '' }} aria-label="Step {{ $i + 1 }}">
                <p>{{ $step['text'] }}</p>
                @if ($step['minutes'])
                    <div class="timer" data-seconds="{{ $step['minutes'] * 60 }}">
                        <b class="timer-face">{{ sprintf('%02d:00', $step['minutes']) }}</b>
                        <button type="button" class="btn btn-primary btn-sm timer-go">@include('partials.icon', ['name' => 'play']) Start timer</button>
                        <button type="button" class="btn btn-ghost btn-sm timer-reset" aria-label="Reset timer">@include('partials.icon', ['name' => 'reset'])</button>
                    </div>
                @else
                    <p class="hint">Take your time. Tap Next when you're ready.</p>
                @endif
            </section>
        @endforeach

        <section class="step-card cook-step finish" data-step="{{ count($steps) }}" hidden>
            <b>🎉</b>
            <p>All done! Enjoy your {{ $post->title }}.</p>
            <div style="margin-top:22px;display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('posts.show', $post->id) }}#rate" class="btn btn-primary">Rate this recipe</a>
                <a href="{{ url('/') }}" class="btn btn-ghost">More recipes</a>
            </div>
        </section>

        <div class="cook-nav">
            <button type="button" class="btn btn-ghost" id="prevStep" disabled>@include('partials.icon', ['name' => 'back']) Previous</button>
            <button type="button" class="btn btn-primary" id="nextStep">Next @include('partials.icon', ['name' => 'next'])</button>
        </div>
    </div>
@endsection
