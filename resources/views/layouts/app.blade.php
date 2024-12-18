<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- this is my original file -->
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/main.css')}}"
        <!-- Styles -->
      
    </head>
    <body>
  
        <div class="container">  
        <!--to avoid reusing code create a layout which will be the base of your HTML -->
         
            
        <header>
            <!-- this are just some includes like messages and the navigation "bar"-->
        @include("includes.nav")
        @include("includes.messages")
        <h1>My Recipes Book</h1>
            <p>Powered by Laravel</p>
          
        </header>
        
        <main>
      
            <!-- this is the content we are loading -->
            <!-- names must match -->
            @yield("content")
        </main>  
           <footer>
            <p>My Recipes Book made by codegunius.</p>
        </footer>
        </div>
     
    </body>
</html>
