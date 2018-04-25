@extends('web-portal.navigation.formwithdatepicker')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Edit Exhibition</h1>
            <div class="row">
                {!! Form::model($exhibition, ['method' => 'patch', 'files' => true, 'route' => ['exhibitions.update', $exhibition->id]]) !!}
                <div class="col-xs-12 col-md-6">
                    <h2>Large Picture for current exhibition and for show-page</h2>
                    <p>Photo must be exactly 1200px width and 300px height</p>
                    <div class="form-group">
                        <?php
                        if(is_null($exhibition->img_1)){
                            ?>
                            *** No Photo Submitted ***                       
                            <?php
                        } else {
                            ?>
                            <img src="/img/exhibitions/<?php echo $exhibition->img_1; ?>" class="img-responsive">                          
                            <?php    
                        }
                        ?>
                        [Select Image]
                        {!! Form::file('img_1', null) !!}
                    </div>
                    <h2>Medium Picture for future exhibitions</h2>
                    <p>Photo must be exactly 600px width and 300px height</p>
                    <div class="form-group">
                        <?php
                        if(is_null($exhibition->img_2)){
                            ?>
                            *** No Photo Submitted ***                       
                            <?php
                        } else {
                            ?>
                            <img src="/img/exhibitions/<?php echo $exhibition->img_2; ?>" class="img-responsive">                          
                            <?php    
                        }
                        ?>
                        [Select Image]
                        {!! Form::file('img_2', null) !!}
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
                        Previous Start-date: {{ $exhibition->start_date }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', 'End Date:') !!}
                        {{ Form::text('end_date', '', array('id' => 'end_date_picker')) }}
                        Previous End-date: {{ $exhibition->end_date }}
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc_1', 'Description:') !!}Maximum 1000 characters. Remaining: <span id="chars_1"></span>
                        {{ Form::textarea('desc_1', null, ['id' => 'desc1', 'size' => '30x10','class'=>'form-control', 'required' => 'required']) }}
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                {!! Form::submit('Save Changes', ['class' => 'btn btn-success form-control', 'name' => 'submit']) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <div class="form-group">
                                <a href="/exhibitions/{{ $exhibition->id }}" class="btn btn-info form-control">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>

@endsection