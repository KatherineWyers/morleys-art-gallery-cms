@extends('ims.navigation.standardpage')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
        <a href="/ims/sales" class="btn btn-info">Sales - Staff</a>&nbsp;
        <a href="/ims/sales/total_sales_report" class="btn btn-info">Sales - Total</a>&nbsp;
        <a href="/ims/sales/list" class="btn btn-info">List of Sales</a>
        
        <h1>List of Sales</h1>
            <div class="row">
                <div class="col-xs-12">
        @forelse($sales_and_online_sales as $sale)
            @if($sale->type == 'Online Sale')
                    <p>{{$sale->artwork_title }} | {{ $sale->type }} | {{ $sale->created_at }} | <a href="/ims/sales/online/{{ $sale->id }}" class='btn btn-lg'>Show</a></p>
            @else
                    <p>{{$sale->artwork_title }} | {{ $sale->type }} | {{ $sale->created_at }} | <a href="/ims/sales/{{ $sale->id }}" class='btn btn-lg'>Show</a></p>
            @endif
        @empty
        @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection