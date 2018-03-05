@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
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
                    <p>{{ $artist->desc_1 }}</p>
                    <p>{{ $artist->desc_2 }}</p>
                </div>
            </div>
        </div>
    </section>
