@extends('web-portal.navigation.standardpage')
@section('content')


    <section id="item" class="container-fluid">
        <div class="wrapper">
        <h1>My Wishlist</h1>

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif


        @forelse($wishlist->artworks as $artwork)
            <div class="row">
                <div class="col-xs-12">
                    <p>{{ $artwork->title }} - {{ $artwork->price }}</p>
                </div>
            </div>
        @empty
            <div class="row">
                <div class="col-xs-12">
                    <p>There is nothing in your wishlist! View artwork and add it to start making your wishlist.</p>
                </div>
            </div>     
        @endforelse
        </div>
    </section>

    <section id="item" class="container-fluid">
        <div class="wrapper">
        <h1>Send Wishlist</h1>
        {!! Form::open(['url' => '/wishlists']) !!}
        <input type="hidden" name="wishlist_id" value="{{ $wishlist->id }}">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    {!! Form::label('name', 'Name:') !!}
                    {!! Form::text('name',null,['class'=>'form-control', 'required' => 'required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    {!! Form::label('email', 'Email:') !!}
                    {!! Form::text('email',null,['class'=>'form-control', 'required' => 'required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}


        </div>

        </div>
    </section>