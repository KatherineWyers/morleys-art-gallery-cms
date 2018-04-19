@extends('ims.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Edit Weekly Timeslots</h1>   

            {!! Form::open(['url' => '/ims/weekly_timeslots/edit']) !!}
            
            <div class="row">
            @forelse($weekly_timeslots as $weekly_timeslot)
                <div class="col-sm-8 form-group">
                    {!! Form::label('weekly_timeslots[]', $weekly_timeslot->dayHour()) !!}
                    {!! Form::checkbox('weekly_timeslots[]', $weekly_timeslot->id,  $weekly_timeslot->checked) !!}
                </div>
            @empty
            @endforelse
            </div>

            <div class="form-group">
                {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </section>
@endsection
