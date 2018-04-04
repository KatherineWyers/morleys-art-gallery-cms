@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
<br /><br /><br /><br />
    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

            <h1>Create a new Artwork</h1>

            {!! Form::open(['url' => 'artworks', 'files' => 'true']) !!}
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <h2>Image 1</h2>
                    <p>Photo must be a minimum 400px width and 400px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_1') !!}
                    </div>
                    <h2>Image 2</h2>
                    <p>Photo must be a minimum 400px width and 400px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_2') !!}
                    </div>
                    <h2>Image 3</h2>
                    <p>Photo must be a minimum 400px width and 400px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_3') !!}
                    </div>
                    <h2>Square Picture for homepage featured-artworks section</h2>
                    <p>Photo must be exactly 300px width and 300px height</p>
                    <div class="form-group">
                        *** No Photo Submitted ***                       
                        {!! Form::file('img_sq') !!}
                    </div>
                </div>
                <div class="col-xs-4 col-sm-6">
                    <div class="form-group">
                        {!! Form::label('title', 'Title:') !!}
                        {!! Form::text('title',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('artist_id', 'Artist:') !!}
                        {!! Form::select('artist_id', $artists, null, ['placeholder' => 'Select Artist', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        <div class="row">
                          <?php $counter = 0;?>
                          @forelse($categories as $category)
                            <div class="col-sm-4">
                              {!! Form::label('categories[]', $category->title) !!}
                              {!! Form::checkbox('categories[]', $category->id) !!}
                            </div>
                            <?php $counter++;
                            if($counter == 3){ echo "</div><div class='row'>";/*create a new row*/ } ?>
                          @empty
                            <div class="col-sm-4">
                              No Category Found
                            </div>
                          @endforelse
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('year_created', 'Year Created:') !!}
                        {!! Form::text('year_created',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('medium', 'Medium:') !!}
                        {!! Form::text('medium',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('desc_1', 'Description:') !!}Maximum 1000 characters. Remaining: <span id="chars_1"></span>
                        {{ Form::textarea('desc_1', null, ['id' => 'desc1', 'size' => '30x10','class'=>'form-control', 'required' => 'required']) }}
                    </div>

                    <div class="form-group">
                        {!! Form::label('width_cm', 'Width cm:') !!}
                        {!! Form::text('width_cm',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('height_cm', 'Height cm:') !!}
                        {!! Form::text('height_cm',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('width_in', 'Width in:') !!}
                        {!! Form::text('width_in',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('height_in', 'Height in:') !!}
                        {!! Form::text('height_in',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('price', 'Price: £') !!}
                        {!! Form::text('price',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Save', ['class' => 'btn btn-success form-control']) !!}
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
