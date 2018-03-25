@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">

            <div class = "row">

                <div class = "col-sm-4">
                    <img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive">
                    <p>{{ $artwork->title }}</p>
                </div>

                <div class = "col-sm-8">

                    <h1>Book an Appointment</h1>  

                    <p>Select Date</p>
                    <a href="/timeslots/{{ $artwork->id }}/{{ $calendar->datetime->copy()->subMonth()->day }}/{{ $calendar->datetime->copy()->subMonth()->month }}/{{ $calendar->datetime->copy()->subMonth()->year }}"><< </a> | 
                    {{ $calendar->monthTitle() }} {{ $calendar->datetime->year }}
                    | <a href="/timeslots/{{ $artwork->id }}/{{ $calendar->datetime->copy()->addMonth()->day }}/{{ $calendar->datetime->copy()->addMonth()->month }}/{{ $calendar->datetime->copy()->addMonth()->year }}"> >></a>

                    <div class="row">
                        <div class="col-sm-1">Sun</div>
                        <div class="col-sm-1">Mon</div>
                        <div class="col-sm-1">Tue</div>
                        <div class="col-sm-1">Wed</div>
                        <div class="col-sm-1">Thu</div>
                        <div class="col-sm-1">Fri</div>
                        <div class="col-sm-1">Sat</div>
                        <div class='col-sm-5'>&nbsp;</div>

                        <div class='col-sm-{{ $calendar->firstDayOfMonth()->dayOfWeek }}'>&nbsp;</div><!-- Offset the first day of the month -->
                    @for ($date = 1; $date < $calendar->daysInMonth(); $date++)
                        <div class="col-sm-1">
                            <a href="/timeslots/{{ $artwork->id }}/{{ $date }}/{{ $calendar->datetime->month }}/{{ $calendar->datetime->year }}">{{ $date }}</a>
                        </div> 
                        @php 
                        $date_with_offset = $calendar->firstDayOfMonth()->dayOfWeek + $date;
                        if($date_with_offset%7 == 0) 
                        {
                           echo "<div class='col-sm-5'>&nbsp;</div>";
                        }
                        @endphp
                    @endfor
                    </div>

                    <h2>Available Timeslots</h2>

                    @forelse($timeslots as $timeslot)
                    <div class="row">
                        <div class="col-xs-12 col-md-8">
                            <p>{{ $timeslot->datetime }}</p>
                        </div>    
                    </div>
                    <hr /> 
                    @empty
                    <p>There are no timeslots available for the selected date</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
