@extends('ims.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif
    <section id="item" class="container-fluid">
        <div class="wrapper">   
        <p>
            <a href="/ims/sales/total_sales_report/{{ Carbon\Carbon::now()->year }}/{{ Carbon\Carbon::now()->month }}/{{ $total_sales_report->taxRate() }}">This Month</a> | 
            <a href="/ims/sales/total_sales_report/{{ Carbon\Carbon::now()->subMonth()->year }}/{{ Carbon\Carbon::now()->subMonth()->month }}/{{ $total_sales_report->taxRate() }}">Last Month</a> | 
            <a href="/ims/sales/total_sales_report/{{ Carbon\Carbon::now()->subMonths(2)->year }}/{{ Carbon\Carbon::now()->subMonths(2)->month }}/{{ $total_sales_report->taxRate() }}">Two Months Ago</a> | 
            <a href="/ims/sales/total_sales_report/{{ Carbon\Carbon::now()->subMonths(3)->year }}/{{ Carbon\Carbon::now()->subMonths(3)->month }}/{{ $total_sales_report->taxRate() }}">Three Months Ago</a>
        </p>
        <p>
            Tax Rate: {{ $total_sales_report->taxRate() }}% | <a href="/ims/sales/total_sales_report/{{ $total_sales_report->year }}/ {{ $total_sales_report->month }}/{{ $total_sales_report->taxRate() + 1 }}">Increase</a> | <a href="/ims/sales/total_sales_report/{{ $total_sales_report->year }}/{{ $total_sales_report->month }}/{{ $total_sales_report->taxRate() - 1 }}">Decrease</a>
        </p>
        <h1>Total Sales Report: {{ $total_sales_report->year }}-{{ $total_sales_report->month }}</h1>
            <div class="row">
                <div class="col-xs-12">
                <p>In-person Sales: £{{ $total_sales_report->sales() }}</p>
                <p>Online Sales: £{{ $total_sales_report->onlineSales() }}</p>
                <hr />
                <p>Total Sales: £{{ $total_sales_report->totalSales() }}</p>
                <p>In-person Sales: £{{ $total_sales_report->sales() }}</p>
                <p>Tax Liability (@ {{ $total_sales_report->taxRate() }}%) : £{{ $total_sales_report->taxLiability() }}</p>
                <hr />
                <p>Total Sales Less Tax Liability : £{{ $total_sales_report->totalSalesLessTaxLiability() }}</p>
                </div>
            </div>
        </div>
    </section>