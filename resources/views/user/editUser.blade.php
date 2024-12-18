@extends('layouts.app')
@section('content')

    <section class="edit">
           <h2>Edit <span> {{$user->name}} </span></h2>
           {{-- the action is to PUT to PostsController update function--}}
            {!! Form::open(['action' => ['UserController@update', $user->id ], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
               <div class="form-group">
                    {{Form::label('name','Username')}}
                    {{--this is how we pass the $post->property as a default value --}}
                    {{Form::text('name',  $user->name )}}
               </div> 
               <div class="form-group">
                    {{Form::label('email','Email')}}
                    {{--this is how we pass the $post->property as a default value --}}
                    {{Form::text('email',  $user->email)}}
               </div> 
                 <div class="form-group">
                    {{Form::label('avatar','Avatar')}}
                    {{Form::file('avatar')}}
                    {{-- hidden file for the image --}}
                    {{-- this is the hidden file --}}
                    {{Form::hidden("imagename", $user->avatar)}}
               </div>  
                  <div class="form-group2">
                    <p>You can change these settings at any time.</p>   
                    <div class="form-edit-meta">
                      
                        {{ Form::submit('Edit User', '')}}

                    </div>
                </div>
                {{Form::hidden("_method", "PUT")}}

            {!! Form::close() !!}

                               
                      
    </section>
    {{-- this is the way we delete the post
        use the destroy function of the controller
        and pass the ID, just like the update,
        that way laravel knows what to delete
     --}}
       {!! Form::open(["action" => ["UserController@destroy", $user->id], "method" => "POST", "class" => "delete"]) !!}
                {{Form::hidden("_method","DELETE")}}
                {{Form::submit('Delete User', '')}}
            {!! Form::close() !!}   
@endsection
