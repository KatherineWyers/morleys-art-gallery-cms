<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Morley's Art Gallery, Stratford-upon-Avon</title>

    <!-- Styles -->
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    @if (Cookie::get('accessible') == NULL)
        <link rel="stylesheet" href="/css/style.css">
    @else
        <link rel="stylesheet" href="/css/style-accessible.css">
    @endif
</head>
<body>
    <div id="app">


        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid wrapper">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNav">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="/">Morley's</a>
                </div>
                <div>
                    <div class="collapse navbar-collapse" id="mainNav">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            <li><a href='/artists'>Artists</a></li>
                            <li><a href='/artworks'>Artworks</a></li>
                            <li><a href='/exhibitions'>Exhibitions</a></li>
                            <li><a href='/news_articles'>News</a></li>
                            @guest    
                            @else               
                                @if  (Auth::user()->isCustomer() == TRUE)
                                    <li><a href='/wishlists/my_wishlist'>My Wishlist</a></li> 
                                @endif
                            @endguest
                            <li><a href='/gallery'>Gallery</a></li>
                            <li><a href='/contact'>Contact</a></li>
                        </ul>

                        <ul class="nav navbar-nav">
                        {!! Form::open(['url' => '/accessibility']) !!}
                        @if (Cookie::get('accessible') == NULL)
                            <input type="hidden" name="accessible" value="TRUE"> 
                            <input type="hidden" name="url" value="{{ Request::url() }}">
                            <li>{!! Form::submit('Large Font', ['class' => 'btn btn-info', 'name' => 'accessibility']) !!}</li>
                        @else
                            <input type="hidden" name="accessible" value="FALSE">
                            <input type="hidden" name="url" value="{{ Request::url() }}">
                            <li>{!! Form::submit('Regular Font', ['class' => 'btn btn-info', 'name' => 'accessibility']) !!}</li>
                        @endif
                        {!! Form::close() !!}
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">

                            @guest
                                <li><a href='/login'>Login</a></li>
                            @else   
                                @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                                    <li><a href='/ims'>IMS</a></li> 
                                @endif
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }}<span class="caret"></span>
                                    </a>                                                   
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest



                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
    @if ($errors->any())
    <section id="item" class="container-fluid">
        <div class="row">
            <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
        </div>
    </section>
    @endif

    @if(Session::has('flash_message'))
    <section id="item" class="container-fluid">
        <div class="row">
            <p class="alert alert-info">{{ Session::get('flash_message') }}</p>
        </div>
    </section>
    @endif

        @yield('content')

        <footer>
            <div class="wrapper">
                <p>Morley's Art Gallery (c) 2018
                @if (Cookie::get('accessible') == NULL)
                        Standard Mode
                @else
                        Accessible Mode
                @endif
                </p>

            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>
    /*
    JQuery adapted from the W3Schools tutorial
    https://www.w3schools.com/bootstrap/bootstrap_ref_js_scrollspy.asp
    */
    $(document).ready(function(){
      $('body').scrollspy({target: ".navbar", offset: 50});   
      $("a").on('click', function(event) {
        if (this.hash !== "") {
          event.preventDefault();
          var hash = this.hash;
          $('html, body').animate({
            scrollTop: $(hash).offset().top
          }, 800, function(){
            window.location.hash = hash;
          });
        }
      });
    });
    </script>

</body>
</html>
