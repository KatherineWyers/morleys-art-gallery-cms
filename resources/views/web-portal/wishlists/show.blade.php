@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">

        <h1>{{ $wishlist->customer->name }} - Wishlist</h1>

        @forelse($wishlist->artworks as $artwork)
            <div class="row">
                <div class="col-xs-4 col-sm-3">
                    <img src="/img/artworks/{{ $artwork->img_sq }}" class="img-responsive">
                    <p>{{ $artwork->title }} - £{{ $artwork->price }} 
                        @if ($artwork->visible)
                            <a href="/pos/w/{{ $artwork->id }}/{{ $wishlist->id }}" class="btn btn-warning">Buy</a>
                        @else
                            <a href="#" class="btn btn-default">Item No Longer Available</a>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-xs-12">
                    <p>This wishlist is empty!</p>
                </div>
            </div>     
        @endforelse
        </div>
    </section>
@endsection