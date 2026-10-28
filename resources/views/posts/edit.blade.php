@extends("layouts.app")
@section("content")
    <section class="edit">
        <h2>Edit Recipe <span> {{ $post->title }} </span></h2>

        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" placeholder="This is the recipe name" required maxlength="120">
            </div>
            <div class="form-group">
                <label for="preptime">Preparation Time</label>
                <input id="preptime" type="text" name="preptime" value="{{ old('preptime', $post->preptime) }}" placeholder="How long the whole recipe takes, e.g. 45 minutes" required maxlength="60">
            </div>
            <div class="form-group">
                <label for="image">Image <small>(leave empty to keep the current photo)</small></label>
                <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe the recipe, give a little overview of what to expect" required>{{ old('description', $post->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea id="ingredients" name="ingredients" placeholder="The ingredients needed, one per line" required>{{ old('ingredients', $post->ingredients) }}</textarea>
            </div>
            <div class="form-group">
                <label for="preparation">Preparation</label>
                <textarea id="preparation" name="preparation" placeholder="The step-by-step preparation" required>{{ old('preparation', $post->preparation) }}</textarea>
            </div>
            <div class="form-group2">
                <p>Proofread your recipe, make sure the information is clear and there are no missing ingredients</p>
                <div class="form-edit-meta">
                    <input type="submit" value="Save Recipe">
                </div>
            </div>
        </form>
    </section>

    @auth
        @if (Auth::id() == $post->user_id)
            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="delete" onsubmit="return confirm('Delete this recipe? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete This Recipe">
            </form>
        @endif
    @endauth
@endsection
