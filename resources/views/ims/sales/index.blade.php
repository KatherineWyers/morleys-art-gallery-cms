@extends('ims.navigation.standardpage')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
        <a href="/ims/sales" class="btn btn-info">Sales - Staff</a>&nbsp;
        <a href="/ims/sales/total_sales_report" class="btn btn-info">Sales - Total</a>&nbsp;
        <a href="/ims/sales/list" class="btn btn-info">List of Sales</a>
        

        <h1>Monthly Sales Report - Staff Sales</h1>
        @forelse($users as $user)
            <div class="row">
                <div class="col-xs-12">
                    Name: {{ $user->name }}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $user->sales_report(2018, 05)->toString() }}</p>
                    <p>{{ $user->sales_report(2018, 04)->toString() }}</p>
                    <p>{{ $user->sales_report(2018, 03)->toString() }}</p>
                    <p>{{ $user->sales_report(2018, 02)->toString() }}</p>
                    <p>{{ $user->sales_report(2018, 01)->toString() }}</p>
                </div>
            </div>

            <hr />
        @empty
        @endforelse
        </div>
    </section>
@endsection