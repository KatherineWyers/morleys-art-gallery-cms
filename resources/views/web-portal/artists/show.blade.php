@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    @guest
                    @else
                        @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                            <p><a href="/artists/{{ $artist->id }}/edit" class="btn btn-lg btn-warning">Edit</a></p>
                        @endif
                    @endguest 

                    <p><img src="/img/artists/{{ $artist->profile_img }}" class="img-responsive"></p>
                    <div class="row">
                        @forelse($artist->artworks as $artwork)
                        <div class="col-xs-4 col-sm-3">
                            <a href="/artworks/{{ $artwork->id }}"><img src="/img/artworks/{{ $artwork->img_sq }}" class="img-responsive"></a>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <h1>{{ $artist->name }}</h1>
                    <p>{!! nl2br(e($artist->desc_1)) !!}</p>
                </div>
            </div>
        </div>
    </section>
