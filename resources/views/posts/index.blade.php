@extends("layouts.app") {{-- we extend the app file which is inside the layouts folder--}} 
@section("content") {{-- this is how we tell laravel what kind of block this is, the content --}}
    <section>
        <h2>Recipes</h2>
    <div class="recipes">
       @if(count($posts) > 0) 
       {{-- we are looping the $posts array--}}
            @foreach ( $posts as $post )
            {{-- for each post we access the data it has --}}
            {{-- we use the object notation for OOP $post->property --}}
                <div class="recipe">
                    <div class="image">
                        <a href="{{ url('/posts/'.$post->id) }}">
                            <div class="outcover" style="background:url('{{ $post->coverUrl() }}') center/cover"></div>
                        </a>
                    </div>
                    <div class="meta">
                        <p class="title">{{$post->title}}</p>
                        <!-- here we get the name of the user
                        that created this post -->
                         <p>Recipe by: <strong>{{ optional($post->user)->name ?? 'Unknown' }}</strong></p>
                         <p class="description"> {{ \Illuminate\Support\Str::limit($post->description, 62) }}</p>
                    </div>
                </div>
            @endforeach
       @endif
    </div>   
    </section>
@endsection


