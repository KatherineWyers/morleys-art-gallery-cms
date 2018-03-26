@extends('web-portal.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif


    <section id="item" class="container-fluid">
        <div class="wrapper">

            <div class = "row">

                <div class = "col-sm-4">
                    <img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive">
                    <p>{{ $artwork->title }}</p>
                </div>

                <div class = "col-sm-8">

                    <h1>Book Appointment</h1>  

                    {!! Form::open(['url' => '/appointments']) !!}
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <input type="hidden" name="datetime" value="{{ $datetime }}">

                    <h2>Enter Your Details</h2>
                    <p>*: Mandatory</p>
                        <div class="form-group">
                            {!! Form::label('name', '*Name:') !!}
                            {!! Form::text('name',null,['class'=>'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone_number', '*Phone Number:') !!}
                            {!! Form::text('phone_number',null,['class'=>'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Complete Booking', ['class' => 'btn btn-warning form-control']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </section>
