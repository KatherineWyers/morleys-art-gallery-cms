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
                </div>   
            </div>

        </div>
    </section>

    <section id="front-page-2" class="container-fluid">
        <div class="wrapper">
            <h1>Featured Artworks
            <div class="row">
                @forelse($featured_artworks as $artwork)
                <div class="col-xs-12 col-sm-4">
                    <img src="/img/artworks/{{ $artwork->img_sq }}" class="img-responsive">
                    <p>{{ $artwork->artist->name }} - {{ $artwork->title }} ({{ $artwork->year_created }})</p>
                    <a href="/artworks/{{ $artwork->id }}" class="btn btn-lg btn-success">Full details</a>
                </div>
                @empty
                @endforelse
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
                        <img src="/img/exhibitions/{{ $exhibition->img_1 }}" class="img-responsive">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <h2>{{ $exhibition->title }}</h2>
                        <p>{{ $exhibition->daterange() }}</p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <p>{{ str_limit($exhibition->desc_1, $limit = 300, $end = '...') }}</p>
                        <p><a href="/exhibitions/{{ $exhibition->id }}" class="btn btn-lg btn-success">Full details</a></p>
                    </div>    
                </div>
                @empty
                @endforelse

                <div class="row">
                    @forelse($upcoming_exhibitions as $exhibition)
                    <div class="col-xs-12 col-sm-6">
                        <img src="/img/exhibitions/{{ $exhibition->img_2 }}" class="img-responsive">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <h2>{{ $exhibition->title }}</h2>
                                <p>{{ $exhibition->daterange() }}</p>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <p><a href="/exhibitions/{{ $exhibition-> id }}" class="btn btn-lg btn-success">Full details</a></p>
                            </div>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section id="front-page-4" class="container-fluid">
        <div class="wrapper">
            <h1>News</h1>

            @forelse($latest_news_articles as $news_article)
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <img src="/img/news_articles/{{ $news_article->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-12 col-md-8">
                    <h2>{{ $news_article->title }}</h2>
                    <p>Publication Date: {{ $news_article->publication_date() }}</p>
                    <p>{{ str_limit($news_article->content, $limit = 300, $end = '...') }}</p>
                    <p><a href="/news_articles/{{ $news_article->id }}" class="btn btn-lg btn-success">Read full article</a></p>
                </div>  
            </div>
            <hr />
            @empty
            @endforelse

        </div>
    </section>

@endsection