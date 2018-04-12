@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">

        <h1>{{ $wishlist->customer->name }} - Wishlist</h1>

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif


        @forelse($wishlist->artworks as $artwork)
            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $artwork->title }} - {{ $artwork->price }} 
                        @if ($artwork->visible)
                            <a href="/pos/{{ $artwork->id }}/{{ $wishlist->id }}" class="btn btn-warning">Buy</a>
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