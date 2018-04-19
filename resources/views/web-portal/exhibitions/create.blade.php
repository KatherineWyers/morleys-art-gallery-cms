@extends('web-portal.navigation.formwithdatepicker')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Create a new Exhibition</h1>
            <div class="row">
                {!! Form::open(['url' => '/exhibitions', 'files' => 'true']) !!}
                <div class="col-xs-12 col-md-6">
                    <h2>Large Picture for current exhibition and for show-page</h2>
                    <p>Photo must be exactly 1200px width and 300px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_1') !!}
                    </div>
                    <h2>Medium Picture for future exhibitions</h2>
                    <p>Photo must be exactly 600px width and 300px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_2') !!}
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('title', 'Title:') !!}
                        {!! Form::text('title',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('start_date', 'Start Date:') !!}
                        {{ Form::text('start_date', '', array('id' => 'start_date_picker')) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', 'End Date:') !!}
                        {{ Form::text('end_date', '', array('id' => 'end_date_picker')) }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc_1', 'Description:') !!}Maximum 1000 characters. Remaining: <span id="chars_1"></span>
                        {{ Form::textarea('desc_1', null, ['id' => 'desc1', 'size' => '30x10','class'=>'form-control', 'required' => 'required']) }}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>
@endsection
