<nav>
   <ul>
    <li><a href="/projects/php/simpleblog/public/posts">Recipes</a></li>
    <li><a href="/projects/php/simpleblog/public/posts/create">Add Recipe</a></li>
      <!-- Authentication Links 
      just copied and editted the file a little-->
      <!-- the views are installed after you set up the make:auth command -->
        @if (Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @else
            <li>
                <a href="{{ route('home') }}" class="username" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>

               
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
               
            </li>
        @endif

   </ul>   
</nav>