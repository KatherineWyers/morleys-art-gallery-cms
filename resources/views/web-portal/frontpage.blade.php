@extends('web-portal.navigation.frontpage')
@section('content')
    <section id="front-page-1" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12">
                    <img src="img/sherpasharelogo-sm.png" class="img-responsive img-rounded transparency">
                </div>              
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <h1>Morley's</h1>
                    <h2>Art Gallery, Straford-upon-Avon</h2>
                </div>   
            </div>

        </div>
    </section>

    <section id="front-page-2" class="container-fluid">
        <div class="wrapper">
            <h1>Featured Artworks
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <img src="#" class="img-responsive img-rounded">
                    <a href="/artists/john-doe/untitled" class="btn btn-lg btn-success">Full details</a>
                </div>
            </div>
        </div>
    </section>

    <section id="front-page-3" class="container-fluid">
        <div class="transparency">
            <div class="wrapper">
                <h1>Current Exhibition</h1>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <img src="#" class="img-responsive img-rounded">
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        John Doe's Exhibition<br />
                        March 1st - 26th 2018
                    </div>
                    <a href="/exhibitions" class="btn btn-lg btn-success">View all exhibitions</a>
                </div>
            </div>
        </div>
    </section>

    <section id="front-page-4" class="container-fluid">
        <div class="wrapper">
            <h1>News</h1>
            <p>Latest news information</p>
            <p>Join our mailing list to stay up-to-date</p>
        </div>
    </section>

@endsection