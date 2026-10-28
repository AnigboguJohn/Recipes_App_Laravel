@extends("layouts.app")
@section("content")
    <section>
        <h2>New Recipe</h2>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="This is the recipe name" required maxlength="120">
            </div>
            <div class="form-group">
                <label for="preptime">Preparation Time</label>
                <input id="preptime" type="text" name="preptime" value="{{ old('preptime') }}" placeholder="How long the whole recipe takes, e.g. 45 minutes" required maxlength="60">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input id="image" type="file" name="image" accept="image/png,image/jpeg,image/webp,image/gif" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Describe the recipe, give a little overview of what to expect" required>{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="ingredients">Ingredients</label>
                <textarea id="ingredients" name="ingredients" placeholder="The ingredients needed, one per line" required>{{ old('ingredients') }}</textarea>
            </div>
            <div class="form-group">
                <label for="preparation">Preparation</label>
                <textarea id="preparation" name="preparation" placeholder="The step-by-step preparation" required>{{ old('preparation') }}</textarea>
            </div>
            <div class="form-group2">
                <p>Proofread your recipe, make sure the information is clear and there are no missing ingredients</p>
                <input type="submit" value="Add Recipe">
            </div>
        </form>
    </section>
@endsection
