@extends('ims.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Process Sale</h1>
            <div class="row">
                <div class="col-xs-12 col-md-4">                   
                    <img src="/img/artworks/{{ $featured_img }}" class="img-responsive">

                </div>
                <div class="col-xs-4 col-sm-4">
                    <h1>{{ $artwork->title }}</h1>
                    <h2>{{ $artwork->artist->name }}</a></h2>
                    <p>
                        @forelse($artwork->categories as $category)
                            {{ $category->title }}, 
                        @empty
                        @endforelse
                    </p>
                    <ul>
                        <li>Year: {{ $artwork->year_created }}</li>
                        <li>{{ $artwork->medium }}</li>
                        <li>{{ $artwork->width_cm }}cm x {{ $artwork->height_cm }}cm</li>
                        <li>{{ $artwork->width_in }}in x {{ $artwork->height_in }}in</li>
                        <li>Price: £{{ $artwork->price }}</li>
                    </ul>
                    <p>{{ str_limit(nl2br(e($artwork->desc_1)), $limit = 100, $end = '...') }}</p>
                </div>

                <div class="col-xs-12 col-md-4">
                    {!! Form::open(['url' => '/ims/sales']) !!}
                    <input type="hidden" name="seller_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <h2>Customer Details</h2>
                        <div class="form-group">
                            {!! Form::label('name', 'Name:') !!}
                            {!! Form::text('name',null,['class'=>'form-control', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone_number', 'Phone Number:') !!}
                            {!! Form::text('phone_number',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('amount', 'Amount:') !!}
                            {!! Form::text('amount', $artwork->price,['class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Complete Transaction', ['class' => 'btn btn-warning form-control']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>