@extends("layouts.app")
@section("content")
   
    <section class="edit">
           <h2>Edit Recipe <span> {{$post->title}} </span></h2>
           {{-- the action is to PUT to PostsController update function--}}
            {!! Form::open(['action' => ['PostsController@update', $post->id ], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
               <div class="form-group">
                    {{Form::label('title','Title')}}
                    {{--this is how we pass the $post->property as a default value --}}
                    {{Form::text('title',  $post->title ,['placeholder' => 'This is the recipe name' ])}}
               </div> 
               <div class="form-group">
                    {{Form::label('preptime','Preparation Time')}}
                    {{Form::text('preptime', $post->preptime ,['placeholder' => 'The time it would take for the whole recipe to be completed, doesnt have to be exact' ])}}
               </div> 
               <div class="form-group">
                    {{Form::label('image','Image')}}
                    {{Form::file('image')}}
                    {{-- hidden file for the image --}}
                    {{-- this is the hidden file --}}
                    {{Form::hidden("imagename", $post->cover)}}
               </div> 
                 <div class="form-group">
                    {{Form::label('description','Description')}}
                    {{Form::textarea('description', $post->description ,['placeholder' => 'Describe the recipe, give a little overview of what to expect ' ])}}
               </div> 
               <div class="form-group">
                    {{Form::label('ingredients','Ingredients')}}
                    {{Form::textarea('ingredients', $post->ingredients ,['placeholder' => 'The ingredients needed for the recipe, separate them with commas' ])}}
               </div> 
               <div class="form-group">
                    {{Form::label('preparation','Preparation')}}
                    {{Form::textarea('preparation', $post->preparation,['placeholder' => 'The detailed recipe preparation process' ])}}
               </div> 
               <div class="form-group2">
                    <p>Proofread your recipe, make sure the information is clear and there are no missing ingredients</p>   
                    <div class="form-edit-meta">
                      
                        {{ Form::submit('Edit Recipe', '')}}

                    </div>
                </div>
                {{-- we need to tell laravel to change the POST to PUT --}}
                {{-- this changes the POST request to a PUT request
                    which is what Laravel is waiting when updating a post --}}
                {{Form::hidden("_method", "PUT")}}

            {!! Form::close() !!}

                               
                      
    </section>
    @if (!Auth::guest())
               @if (Auth::user()->id == $post->user_id)
                 {!! Form::open(["action" => ["PostsController@destroy", $post->id], "method" => "POST", "class" => "delete"]) !!}
                {{Form::hidden("_method","DELETE")}}
                {{Form::submit('Delete This Post', '')}}
            {!! Form::close() !!}   
               @endif 
            @endif
      
@endsection
