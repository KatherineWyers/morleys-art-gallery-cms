@extends('ims.navigation.standardpage')
@section('content')
    <section id="standard-page-1" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <img src="img/logo-315x249.png" class="img-responsive">
                </div>  
                <div class="col-xs-12 col-md-6">
                    <h1>Information Management System</h1>
                </div>  
                <div class="col-xs-12 col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Online Sales Awaiting Collection
                        </div>
                        <div class="panel-body">
                        @forelse($online_sales_awaiting_collection as $online_sale)
                            <p>{{ $online_sale->artwork->title }} - <a href="/ims/sales/online/{{ $online_sale->id }}" class='btn btn-lg'>Show</a></p>
                        @empty
                            <p>No online-sales awaiting collection</p>
                        @endforelse
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </section>
@endsection