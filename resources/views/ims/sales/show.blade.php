@extends('ims.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
          <h1>Sales Contract</h1>
            <div class="row">
                <div class="col-xs-12 col-md-6">      
                    <img src="/img/artworks/{{ $sale->artwork->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $sale->artwork->title }}</h1>
                    <h2>{{ $sale->artwork->artist->name }}</a></h2>
                    <p>
                        @forelse($sale->artwork->categories as $category)
                            {{ $category->title }}, 
                        @empty
                        @endforelse
                    </p>
                    <ul>
                        <li>Date of Sale: {{ $sale->created_at }}</li>
                        <li>Type of Sale: In-Person Sale</li>
                        <li>Customer Name: {{ $sale->name }}</li>
                        <li>Customer Email: {{ $sale->email }}</li>
                        <li>Customer Email: {{ $sale->phone_number }}</li>
                        <li>Seller Name: {{ $sale->seller->name }}</li>
                        <li>Listed Price: £{{ $sale->artwork->price }}</li>
                        <li>Price Paid: £{{ $sale->amount }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
