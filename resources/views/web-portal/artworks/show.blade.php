@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <img src="/img/placeholders/400x600.png" class="img-responsive">
                    <div class="row">
                        <div class="col-xs-4 col-sm-3">
                            <img src="/img/placeholders/400x600.png" class="img-responsive"> 
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <img src="/img/placeholders/400x600.png" class="img-responsive"> 
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <img src="/img/placeholders/400x600.png" class="img-responsive">  
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <h1>{{ $artwork->title }}</h1>
                    <h2>{{ $artwork->artist->name }}</h2>
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
                </div>
            </div>
            <div class="row">
                <a href="/artworks/2">Next</a>
            </div>
        </div>
    </section>
