@extends('web-portal.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Artworks</h1>
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
        </div>
    </section>
