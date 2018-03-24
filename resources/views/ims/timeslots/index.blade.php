@extends('ims.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Timeslots</h1>   
            <p><a href="/ims/timeslots/edit" class="btn btn-lg btn-warning">Edit Timeslots</a></p> 

            <div class="row"">
            @forelse($timeslots as $timeslot)
                <div class="col-sm-12
                @if ($timeslot->checked == TRUE)
                    bg-success
                @endif
                ">
                {{ $timeslot->day }} - {{ $timeslot->hour }}:00
                </div>
            @empty
            @endforelse
            </div>
            
        </div>
    </section>
