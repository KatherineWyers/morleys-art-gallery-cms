@extends('ims.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

    <section id="item" class="container-fluid">
        <div class="wrapper">
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