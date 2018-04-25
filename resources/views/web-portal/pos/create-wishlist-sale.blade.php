@extends('web-portal.navigation.standardpage')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Gift Checkout</h1>
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
                    <h2>Recipient</h2>

                    <p>{{ $wishlist->customer->name }}</p>

                    <hr />

                    {!! Form::open(['url' => '/pos']) !!}
                    <input type="hidden" name="customer_id" value="{{ $wishlist->customer->id }}">
                    <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">
                    <h2>Your Details</h2>
                    <p>Warning: this is a demonstration application. Do NOT enter valid credit card details!</p>
                    <div class="form-group">
                        {!! Form::label('purchaser_name', 'Name:') !!}
                        {!! Form::text('purchaser_name',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('purchaser_email', 'Email:') !!}
                        {!! Form::text('purchaser_email',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <hr />
                    <h2>Payment Details</h2>
                    <div class="form-group">
                        {!! Form::label('cc_name', 'Name on Credit Card:') !!}
                        {!! Form::text('cc_name',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('cc_number', 'Card Number:') !!}
                        {!! Form::text('cc_number', null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('cc_exp_mm', 'Exp Month:') !!}
                        {!! Form::text('cc_exp_mm', null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('cc_exp_yyyy', 'Exp Year:') !!}
                        {!! Form::text('cc_exp_yyyy', null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('cc_cvv', 'CVV:') !!}
                        {!! Form::text('cc_cvv', null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Complete Transaction', ['class' => 'btn btn-warning form-control', 'name' => 'submit']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection