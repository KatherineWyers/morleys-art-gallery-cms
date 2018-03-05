@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>News</h1>  

            @forelse($news_articles as $news_article)
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <img src="/img/news_articles/{{ $news_article->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-12 col-md-8">
                    <h1>{{ $news_article->title }}</h1>
                    <h2>Publication Date: {{ $news_article->publication_date() }}</h2>
                    <p>{{ str_limit($news_article->content, $limit = 300, $end = '...') }}</p>
                    <p><a href="/news_articles/{{ $news_article->id }}" class="btn btn-lg btn-success">Read full article</a></p>
                </div>    
            </div>
            <hr /> 
            @empty
            @endforelse

            {{ $news_articles->links()}}

        </div>
    </section>
