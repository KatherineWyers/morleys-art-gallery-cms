@extends('ims.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Delete Appointment</h1>
            <div class="row">
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $appointment->datetime }}</h1>
                    <h2>{{ $appointment->artwork->title }}</a></h2>
                    <ul>
                        <li>Customer Name: {{ $appointment->name }}</li>
                        <li>Customer Email: {{ $appointment->email }}</li>
                        <li>Customer Phone Number: {{ $appointment->phone_number }}</li>
                    </ul>
                    <p>Are you sure you want to delete this appointment?</p>
                    <a href='/ims/appointments/destroy/{{ $appointment->id }}' class='btn btn-lg btn-danger'>Confirm Delete</a>
                </div>
            </div>
        </div>
    </section>
@endsection