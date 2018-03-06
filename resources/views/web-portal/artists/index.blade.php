@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Artists</h1>
            @guest
            @else
            <p><a href="/artists/create" class="btn btn-lg btn-warning">+ Add New Artist</a></p>
            @endguest
            <div class="row">
                @forelse($artists as $artist)
                <div class="col-xs-6 col-sm-3 col-md-2">
                    <a href="/artists/{{ $artist->id }}"><img src="/img/artists/{{ $artist->featured_artwork_img_sm }}" class="img-responsive"><p>{{ $artist->name }}</p></a>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>
