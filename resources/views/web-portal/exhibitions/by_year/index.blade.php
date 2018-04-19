@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>{{ $yyyy }} Exhibitions</h1>
            <p>
                <a href="/exhibitions/by-year/2015">2015</a> | 
                <a href="/exhibitions/by-year/2016">2016</a> | 
                <a href="/exhibitions/by-year/2017">2017</a> | 
                <a href="/exhibitions/by-year/2018">2018</a>
            </p>

            @forelse($exhibitions_by_year as $exhibition)
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <img src="/img/exhibitions/{{ $exhibition->img_2 }}" class="img-responsive">
                </div>
                <div class="col-xs-12 col-sm-8">
                    <h2>{{ $exhibition->title }}</h2>
                    <p>{{ $exhibition->daterange() }}</p>
                    <p>{{ str_limit($exhibition->desc_1, $limit = 300, $end = '...') }}</p>
                    <a href="/exhibitions/{{ $exhibition->id }}" class="btn btn-lg btn-info">Full details</a>
                </div>
            </div>
            @empty
            @endforelse
            
            {{ $exhibitions_by_year->links()}}

        </div>
    </section>

@endsection