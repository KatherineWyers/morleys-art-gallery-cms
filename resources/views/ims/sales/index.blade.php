@extends('ims.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

    <section id="item" class="container-fluid">
        <div class="wrapper">
        <h1>Monthly Sales Report</h1>
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