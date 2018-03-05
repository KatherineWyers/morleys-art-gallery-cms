@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="standard-page" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <img src="/img/news_articles/{{ $news_article->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-12 col-md-8">
                    <h1>{{ $news_article->title }}</h1>
                    <h2>Published on: {{ $news_article->created_at }}</h2>
                    <p>{{ $news_article->content }}</p>
                </div>
            </div>
        </div>
    </section>
