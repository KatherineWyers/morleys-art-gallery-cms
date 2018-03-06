@extends('web-portal.navigation.frontpage')
@section('content')
    <section id="front-page-1" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <img src="img/logo-315x249.png" class="img-responsive">
                </div>              
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h2>Art Gallery, Straford-upon-Avon</h2>
                    <div class="row">
                        <div class = "col-xs-12 col-sm-4 col-sm-offset-2">
                            <a href="/#front-page-2" class="btn btn-lg btn-warning btn-block">Featured Artworks <span class="glyphicon glyphicon-chevron-down"></span></a>
                        </div>
                        <div class = "col-xs-12 col-sm-4">
                            <a href="/artists" class="btn btn-lg btn-success btn-block">View Artists <span class="glyphicon glyphicon-triangle-right"></span></a>
                        </div>
                    </div>
                </div>   
            </div>

        </div>
    </section>

    <section id="front-page-2" class="container-fluid">
        <div class="wrapper">
            <h1>Featured Artworks
            <div class="row">
                @forelse($featured_artworks as $artwork)
                <div class="col-xs-4 col-sm-2">
                    <a href="/artworks/{{ $artwork->id }}">
                    <img src="/img/artworks/{{ $artwork->img_sq }}" class="img-responsive">
                    <p>{{ $artwork->artist->name }} - {{ $artwork->title }} ({{ $artwork->year_created }})</p>
                    <p>Price: £{{ $artwork->price }}</p>
                    </a>
                </div>
                @empty
                @endforelse
            </div>
            <div class="buffer-sm">
            </div>
            <div class="row">
                <div class = "col-xs-12 col-sm-4 col-sm-offset-2">
                    <a href="/artworks" class="btn btn-lg btn-success btn-block">View More Artwork <span class="glyphicon glyphicon-triangle-right"></span></a>
                </div>
                <div class = "col-xs-12 col-sm-4">
                    <a href="/artists" class="btn btn-lg btn-success btn-block">View Artists <span class="glyphicon glyphicon-triangle-right"></span></a>
                </div>
            </div>
        </div>
    </section>

    <section id="front-page-3" class="container-fluid">
        <div class="transparency">
            <div class="wrapper">
                @forelse($current_exhibitions as $exhibition)
                <h1>Current Exhibition</h1>
                <div class="row">
                    <div class="col-xs-12">
                        <a href="/exhibitions/{{ $exhibition->id }}">
                        <img src="/img/exhibitions/{{ $exhibition->img_1 }}" class="img-responsive">
                        <h2>{{ $exhibition->title }}</h2>
                        <p>{{ $exhibition->daterange() }}</p>
                        </a>
                    </div>
                </div>
                @empty
                @endforelse

                <div class="row">
                    <div class = "col-xs-12 col-sm-6 col-sm-offset-3">
                        <a href="/exhibitions" class="btn btn-lg btn-success btn-block">View All Exhibitions <span class="glyphicon glyphicon-triangle-right"></span></a>
                    </div> 
                </div>

            </div>
        </div>
    </section>

    <section id="front-page-4" class="container-fluid">
        <div class="wrapper">
            <h1>Lastest News</h1>
            <div class="row">
            @forelse($latest_news_articles as $news_article)
                <div class="col-xs-12 col-md-6">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <a href="/news_articles/{{ $news_article->id }}"><img src="/img/news_articles/{{ $news_article->img_1 }}" class="img-responsive"></a>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <a href="/news_articles/{{ $news_article->id }}"><h2>{{ $news_article->title }}</h2>
                            <p>Publication Date: {{ $news_article->publication_date() }}</p></a>
                            </a>
                        </div>
                    </div>
                </div> 
            @empty
            @endforelse
            </div>

            <div class="buffer-sm">
            </div>

            <div class="row">
                <div class = "col-xs-12 col-sm-4 col-sm-offset-4">
                    <a href="/news_articles" class="btn btn-lg btn-success btn-block">View More News Articles <span class="glyphicon glyphicon-triangle-right"></span></a>
                </div>
            </div>

        </div>
    </section>

@endsection