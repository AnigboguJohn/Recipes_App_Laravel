@extends("layouts.app")
@section("content")
    <section>
        <h2>{{$post->title}}  <span>ready in {{ $post->preptime}} </span></h2>
        <div class="recipeContainer">   
            <div>
           
                <div class="cover" style="background:url('{{ $post->coverUrl() }}') center/cover"></div>
            </div>
            
            <div>
                <p class="title">Ingredients</p>
                <p>{!! nl2br(e($post->ingredients)) !!}</p>
            </div>
            <div>
                <p class="title">Description</p>
                <p>{!! nl2br(e($post->description)) !!}</p>
            </div>
            <div>
                <p class="title">Preparation</p>
                <p>{!! nl2br(e($post->preparation)) !!}</p>
            </div>
            <div>
                <p>Recipe by: <strong>{{ optional($post->user)->name ?? 'Unknown' }}</strong></p>
            </div>
            <!-- here is a sample of authorization 
                we check if the user is a guest, in this case that is not a guest
                and that the ID of the user is the same ID of the post in the user_id column
                which if its true, it belongs to the user, and can have access
                to the edit and delete buttons
            -->
            @if (!Auth::guest())
               @if (Auth::user()->id == $post->user_id)
                <div>
                    <p><a class="editPost" href="{{ url('/posts/'.$post->id.'/edit') }}">Edit this post</a></p>
                </div>       
               @endif 
            @endif
            
        </div>
    </section>
@endsection


