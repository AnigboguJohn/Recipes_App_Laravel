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
                        <a href="/projects/php/simpleblog/public/posts/{{$post->id}}">
                            <div class="outcover" style='background:url("storage/covers/{{$post->cover}}")center;background-size:100%'></div>
                        </a>
                    </div>
                    <div class="meta">
                        <p class="title">{{$post->title}}</p>
                        <!-- here we get the name of the user
                        that created this post -->
                         <p>Recipe by: <strong>{{$post->user->name}}</strong></p>
                         <p class="description"> {{str_limit($post->description, 62)}}</p>
                    </div>
                </div>
            @endforeach
       @endif
    </div>   
    </section>
@endsection


