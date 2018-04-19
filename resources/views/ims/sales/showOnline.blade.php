@extends('ims.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
        <a href="/ims/sales" class="btn btn-info">Sales - Staff</a>&nbsp;
        <a href="/ims/sales/total_sales_report" class="btn btn-info">Sales - Total</a>&nbsp;
        <a href="/ims/sales/list" class="btn btn-info">List of Sales</a>
        
          <h1>Sales Contract</h1>
            <div class="row">
                <div class="col-xs-12 col-md-6">      
                    <img src="/img/artworks/{{ $online_sale->artwork->img_1 }}" class="img-responsive">
                </div>
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $online_sale->artwork->title }}</h1>
                    <h2>{{ $online_sale->artwork->artist->name }}</h2>
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

                    @if ($online_sale->collected == FALSE)
                            <a href="/ims/sales/online/mark_as_collected/{{ $online_sale->id }}" class='btn btn-lg btn-warning'>Mark As Collected</a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection