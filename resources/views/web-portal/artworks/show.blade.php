@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">                   
                    @guest
                    @else
                    <p><a href="/artworks/{{ $artwork->id }}/edit" class="btn btn-lg btn-warning">Edit</a></p>
                    @endguest
                    <img src="/img/artworks/{{ $featured_img }}" class="img-responsive">

                </div>
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $artwork->title }}</h1>
                    <h2><a href="/artists/{{ $artwork->artist->id }}">{{ $artwork->artist->name }}</a></h2>
                    <p>
                        @forelse($artwork->categories as $category)
                            <a href="/artworks/c/{{ $category->id }}">{{ $category->title }}</a>, 
                        @empty
                        @endforelse
                    </p>
                    <ul>
                        <li>Year: {{ $artwork->year_created }}</li>
                        <li>{{ $artwork->medium }}</li>
                        <li>{{ $artwork->width_cm }}cm x {{ $artwork->height_cm }}cm</li>
                        <li>{{ $artwork->width_in }}in x {{ $artwork->height_in }}in</li>
                        <li>Price: £{{ $artwork->price }}</li>
                    </ul>
                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/1"><img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive"></a>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/2"><img src="/img/artworks/{{ $artwork->img_2 }}" class="img-responsive"></a>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/3"><img src="/img/artworks/{{ $artwork->img_3 }}" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
