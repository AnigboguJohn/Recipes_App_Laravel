{{-- Recipe form shared by "Add recipe" and "Edit recipe". --}}
@php
    $err = function ($f) use ($errors) { return $errors->has($f) ? 'error' : ''; };
    $cat = old('category', $post->category ?: 'Lunch');
    $diff = old('difficulty', $post->difficulty);
@endphp
<div class="form">
    <div class="field {{ $err('image') }}">
        <span class="label">Photo @if ($post->exists)<small>(leave empty to keep the current photo)</small>@endif</span>
        <label class="drop" for="image">
            @if ($post->exists && $post->cover)<img src="{{ $post->coverUrl() }}" alt="" class="drop-preview">@else<img alt="" class="drop-preview" hidden>@endif
            @include('partials.icon', ['name' => 'camera'])
            <b>Tap to add a photo</b>
            <small>JPG, PNG, WebP or GIF · up to 2 MB</small>
            <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp,image/gif" {{ $post->exists ? '' : 'required' }}>
        </label>
        @error('image')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field {{ $err('title') }}">
        <label for="title">Recipe name</label>
        <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="e.g. Nigerian Jollof Rice" required maxlength="120">
        @error('title')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field {{ $err('category') }}">
        <span class="label">Category</span>
        <div class="pick" role="radiogroup" aria-label="Category">
            @foreach (\App\Post::CATEGORIES as $name => $icon)
                <input type="radio" id="cat-{{ $name }}" name="category" value="{{ $name }}" {{ $cat === $name ? 'checked' : '' }}>
                <label for="cat-{{ $name }}">{{ $icon }} {{ $name }}</label>
            @endforeach
        </div>
        @error('category')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="row-2">
        <div class="field {{ $err('preptime') }}">
            <label for="preptime">Cooking time</label>
            <input id="preptime" type="text" name="preptime" value="{{ old('preptime', $post->preptime) }}" placeholder="e.g. 45 minutes" required maxlength="60">
            @error('preptime')<span class="err">{{ $message }}</span>@enderror
        </div>
        <div class="field {{ $err('servings') }}">
            <label for="servings">Servings <small>(optional)</small></label>
            <input id="servings" type="number" name="servings" min="1" max="50" value="{{ old('servings', $post->servings) }}" placeholder="e.g. 4">
            @error('servings')<span class="err">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="row-2">
        <div class="field {{ $err('difficulty') }}">
            <span class="label">Difficulty <small>(optional)</small></span>
            <div class="pick" role="radiogroup" aria-label="Difficulty">
                @foreach (\App\Post::DIFFICULTIES as $d)
                    <input type="radio" id="diff-{{ $d }}" name="difficulty" value="{{ $d }}" {{ $diff === $d ? 'checked' : '' }}>
                    <label for="diff-{{ $d }}">{{ $d }}</label>
                @endforeach
            </div>
        </div>
        <div class="field {{ $err('calories') }}">
            <label for="calories">Calories per serving <small>(optional)</small></label>
            <input id="calories" type="number" name="calories" min="0" max="5000" value="{{ old('calories', $post->calories) }}" placeholder="e.g. 420">
            @error('calories')<span class="err">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="field {{ $err('description') }}">
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="A short overview: what it is and what it tastes like" required maxlength="2000">{{ old('description', $post->description) }}</textarea>
        @error('description')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field {{ $err('ingredients') }}">
        <label for="ingredients">Ingredients <small>(one per line)</small></label>
        <textarea id="ingredients" name="ingredients" placeholder="3 cups rice&#10;4 tomatoes&#10;2 onions" required maxlength="5000">{{ old('ingredients', $post->ingredients) }}</textarea>
        @error('ingredients')<span class="err">{{ $message }}</span>@enderror
    </div>

    <div class="field {{ $err('preparation') }}">
        <label for="preparation">Steps <small>(one per line; mention minutes like "fry for 5 minutes" to get a timer)</small></label>
        <textarea id="preparation" name="preparation" placeholder="Wash the rice.&#10;Fry the onions for 5 minutes.&#10;Add the tomato mix and cook for 20 minutes." required maxlength="10000">{{ old('preparation', $post->preparation) }}</textarea>
        @error('preparation')<span class="err">{{ $message }}</span>@enderror
    </div>
</div>
