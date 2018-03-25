@extends('ims.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Timeslots</h1>   
            <p><a href="/ims/weekly_timeslots/edit" class="btn btn-lg btn-warning">Edit Weekly Timeslots</a></p> 

            <div class="row"">
            @forelse($weekly_timeslots as $weekly_timeslot)
                <div class="col-sm-12
                @if ($weekly_timeslot->checked == TRUE)
                    bg-success
                @endif
                ">
                {{ $weekly_timeslot->day }} - {{ $weekly_timeslot->hour }}:00
                </div>
            @empty
            @endforelse
            </div>
            
        </div>
    </section>
