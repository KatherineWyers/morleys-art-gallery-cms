@extends('ims.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Edit Timeslots</h1>   

            {!! Form::open(['url' => '/ims/timeslots/edit']) !!}
            
            <div class="row">
            @forelse($timeslots as $timeslot)
                <div class="col-sm-8 form-group">
                    {!! Form::label('timeslots[]', $timeslot->dayHour()) !!}
                    {!! Form::checkbox('timeslots[]', $timeslot->id,  $timeslot->checked) !!}
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
