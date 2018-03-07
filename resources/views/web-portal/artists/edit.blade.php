@extends('web-portal.navigation.standardpage')
@section('content')

    @if ($errors->any())
        <p class="text-danger">{{ implode('', $errors->all(':message')) }}</p>
    @endif

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Edit Artist</h1>
            <div class="row">
                {!! Form::model($artist, ['method' => 'patch', 'files' => true, 'route' => ['artists.update', $artist->id]]) !!}
                <div class="col-xs-12 col-md-6">
                    <h2>Profile Picture</h2>
                    <p>Photo must be a minimum 400px width and 400px height</p>
                    <div class="form-group">
                        <?php
                        if(is_null($artist->profile_img)){
                            ?>
                            *** No Photo Submitted ***                       
                            <?php
                        } else {
                            ?>
                            <img src="/img/artists/<?php echo $artist->profile_img; ?>" class="img-responsive">                          
                            <?php    
                        }
                        ?>
                        [Select Image]
                        {!! Form::file('profile_img', null) !!}
                    </div>
                    <h2>Large Background Picture for /artists page</h2>
                    <p>Photo must be exactly 1240px width and 700px height</p>
                    <div class="form-group">
                        <?php
                        if(is_null($artist->featured_artwork_img_lg)){
                            ?>
                            *** No Photo Submitted ***                       
                            <?php
                        } else {
                            ?>
                            <img src="/img/artists/<?php echo $artist->featured_artwork_img_lg; ?>" class="img-responsive">                          
                            <?php    
                        }
                        ?>
                        [Select Image]
                        {!! Form::file('featured_artwork_img_lg', null) !!}
                    </div>
                    <h2>Square Picture for /artists page</h2>
                    <p>Photo must be exactly 300px width and 300px height</p>
                    <div class="form-group">
                        <?php
                        if(is_null($artist->featured_artwork_img_sm)){
                            ?>
                            *** No Photo Submitted ***                       
                            <?php
                        } else {
                            ?>
                            <img src="/img/artists/<?php echo $artist->featured_artwork_img_sm; ?>" class="img-responsive">                          
                            <?php    
                        }
                        ?>
                        [Select Image]
                        {!! Form::file('featured_artwork_img_sm', null) !!}  
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Name:') !!}
                        {!! Form::text('name',null,['class'=>'form-control', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('desc_1', 'Description:') !!}Maximum 1000 characters. Remaining: <span id="chars_1"></span>
                        {{ Form::textarea('desc_1', null, ['id' => 'desc1', 'size' => '30x10','class'=>'form-control', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-success form-control']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <a href="/artists/{{ $artist->id }}" class="btn btn-info form-control">Cancel</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </section>


<script>

        // Text Counter

        (function($) {
            $.fn.extend( {
                limiter: function(limit, elem) {
                    $(this).on("keyup focus", function() {
                        setCount(this, elem);
                    });
                    function setCount(src, elem) {
                        var chars = src.value.length;
                        if (chars > limit) {
                            src.value = src.value.substr(0, limit);
                            chars = limit;
                        }
                        elem.html( limit - chars );
                    }
                    setCount($(this)[0], elem);
                }
            });
        })(jQuery);

        var elem1 = $("#chars_1");
        $("#desc1").limiter(750, elem1);

    </script>