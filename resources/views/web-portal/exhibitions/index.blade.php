@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Current Exhibition</h1>

            @forelse($current_exhibitions as $exhibition)
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


            <h1>Future Exhibitions</h1>
            <div class="row">
                @forelse($exhibitions_in_the_next_365_days as $exhibition)
                <div class="col-xs-12 col-sm-6">
                    <img src="/img/exhibitions/{{ $exhibition->img_2 }}" class="img-responsive">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <p>{{ $exhibition->title }}</p>
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

            <h1>Exhibitions By Year</h1>
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <p><a href="/exhibitions/by-year/2015" class="btn btn-lg btn-info">2015</a></p>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <p><a href="/exhibitions/by-year/2016" class="btn btn-lg btn-info">2016</a></p>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <p><a href="/exhibitions/by-year/2017" class="btn btn-lg btn-info">2017</a></p>
                </div>
                <div class="col-xs-12 col-sm-3">
                    <p><a href="/exhibitions/by-year/2018" class="btn btn-lg btn-info">2018</a></p>
                </div>
            </div>

            <div class="buffer-sm">
            </div>
        </div>
    </section>
