@extends('ims.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

    <section id="item" class="container-fluid">
        <div class="wrapper">
        <h1>Total Unique Visits in the past 30 days</h1>
        <p>When a guest visits a page multiple times, it is only counted once.</p>
        @forelse($visits as $visit)
            <div class="row">
                <div class="col-xs-12">
                    <p>URL: {{ $visit->url }} => Visits: {{ $visit->total }}</p>
                </div>
            </div>

            <hr />
        @empty
        @endforelse
        </div>
    </section>