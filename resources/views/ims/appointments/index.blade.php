@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">

            <div class = "row">

                <div class = "col-sm-12">

                    <h1>Appointments</h1>  

                    <p>Select Date</p>
                    <a href="/ims/appointments/{{ $calendar->datetime->copy()->subMonth()->day }}/{{ $calendar->datetime->copy()->subMonth()->month }}/{{ $calendar->datetime->copy()->subMonth()->year }}"><< </a> | 
                    {{ $calendar->monthTitle() }} {{ $calendar->datetime->year }}
                    | <a href="/ims/appointments/{{ $calendar->datetime->copy()->addMonth()->day }}/{{ $calendar->datetime->copy()->addMonth()->month }}/{{ $calendar->datetime->copy()->addMonth()->year }}"> >></a>

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
                        
                        @if ($date == $calendar->datetime->day)
                        <div class="col-sm-1">
                            <a href="#" class="text-warning">[{{ $date }}]</a>
                        </div> 
                        @else
                        <div class="col-sm-1">
                            <a href="/ims/appointments/{{ $date }}/{{ $calendar->datetime->month }}/{{ $calendar->datetime->year }}">{{ $date }}</a>
                        </div> 
                        @endif
                       
                        @php 
                        $date_with_offset = $calendar->firstDayOfMonth()->dayOfWeek + $date;
                        if($date_with_offset%7 == 0) 
                        {
                           echo "<div class='col-sm-5'>&nbsp;</div>";
                        }
                        @endphp
                    @endfor
                    </div>

                    <h2>Appointments for the selected date</h2>

                    @forelse($appointments as $appointment)
                    <div class="row">
                        <div class="col-xs-12 col-md-8">
                            <p>
                                Date time: {{ $appointment->datetime()->format('l jS \\of F Y h:i A') }}<br />
                                Artwork: {{ $appointment->artwork->title }}<br />
                                Customer name: {{ $appointment->name }}<br />
                                Customer phone no.: {{ $appointment->phone_number }}<br />
                                Customer email: {{ $appointment->email }}
                                <a href="/ims/appointments/delete/{{ $appointment->id }}" class="btn btn-lg btn-danger">Delete</a>
                                @if ($appointment->led_to_sale == FALSE)
                                    <a href="/ims/appointments/mark_as_sale/{{ $appointment->id }}" class="btn btn-lg btn-success">Mark As Sale</a>                                    
                                @endif
                            </p>

                        </div>    
                    </div>
                    <hr /> 
                    @empty
                    <p>There are no appointments for the selected date</p>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
@endsection
