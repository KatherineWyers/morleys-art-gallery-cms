@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="standard-page" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                @guest
                @else
                    @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                        <p><a href="/exhibitions/{{ $exhibition->id }}/edit" class="btn btn-lg btn-warning">Edit</a></p>
                    @endif
                @endguest 
                <div class="col-xs-12">
                    <img src="/img/exhibitions/{{ $exhibition->img_1 }}" class="img-responsive">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <h1>{{ $exhibition->title }}</h1>
                    <h2>{{ $exhibition->daterange() }}</h2>
                </div>
                <div class="col-xs-12 col-md-8">
                    <p>{!! nl2br(e($exhibition->desc_1)) !!}</p>
                </div>
            </div>
        </div>
    </section>
