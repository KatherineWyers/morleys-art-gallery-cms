@extends('ims.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
          <h1>Sales Contract</h1>
            <div class="row">
                <div class="col-xs-12 col-md-6">      
                    <img src="/img/artworks/{{ $online_sale->artwork->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $online_sale->artwork->title }}</h1>
                    <h2>{{ $online_sale->artwork->artist->name }}</a></h2>
                    <p>
                        @forelse($online_sale->artwork->categories as $category)
                            {{ $category->title }}, 
                        @empty
                        @endforelse
                    </p>
                    <ul>
                        <li>Date of Sale: {{ $online_sale->created_at }}</li>
                        <li>Type of Sale: Online Sale</li>
                        <li>Purchaser Name: {{ $online_sale->purchaser_name }}</li>
                        <li>Purchaser Email: {{ $online_sale->purchaser_email }}</li>
                        <li>Receiver Name: {{ $online_sale->customer->name }}</li>
                        <li>Receiver Email: {{ $online_sale->customer->email }}</li>
                        <li>Price Paid: £{{ $online_sale->artwork->price }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
