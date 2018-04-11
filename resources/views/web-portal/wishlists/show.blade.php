@extends('web-portal.navigation.standardpage')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
        <h1>My Wishlist</h1>

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif


        @forelse($wishlist->artworks as $artwork)
            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $artwork->title }} - {{ $artwork->price }}</p>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-xs-12">
                    <p>There is nothing in your wishlist! View artwork and add it to start making your wishlist.</p>
                </div>
            </div>     
        @endforelse
        </div>
    </section>