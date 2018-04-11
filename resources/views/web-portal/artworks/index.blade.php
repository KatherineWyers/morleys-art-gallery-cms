@extends('web-portal.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Artworks {{ $category_title }}</h1>   
            @guest
            @else
                @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                    <p><a href="/artworks/create" class="btn btn-lg btn-warning">+ Add New Artwork</a></p>
                @endif
            @endguest         
            <p>
                <a href="/artworks/c/0">All</a> | 
                @forelse($categories as $category)
                <a href="/artworks/c/{{ $category->id }}">{{ $category->title }}</a> | 
                @empty
                @endforelse
                <a href="/artworks/max-price/1000">Under £1000</a>
            </p>
            <div class="row">
                @forelse($artworks as $artwork)
                <div class="col-xs-6 col-sm-3 col-md-2">
                    <a href="/artworks/{{ $artwork->id }}"><img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive">
                    <p>{{ $artwork->title }}</p>
                    <p>{{ $artwork->artist->name }}</p>
                    <p>Price: £{{ $artwork->price }}</p>
                    </a>
                </div>
                @empty
                @endforelse
            </div>

            {{ $artworks->links()}}
        </div>
    </section>
