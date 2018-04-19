@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Artists</h1>
            @guest
            @else
                @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                    <p><a href="/artists/create" class="btn btn-lg btn-warning">+ Add New Artist</a></p>
                @endif
            @endguest  
            <div class="row">
                <?php $index = 1; ?>

                @forelse($artists as $artist)
                <div class="col-xs-6 col-sm-3 col-md-2 col-lg-2">
                    <a href="/artists/{{ $artist->id }}"><img src="/img/artists/{{ $artist->featured_artwork_img_sm }}" class="img-responsive"><p>{{ $artist->name }}</p></a>
                </div>
                <?php
                $twoCols = ($index % 2) == 0;
                $fourCols  = ($index % 4) == 0;
                $sixCols = ($index % 6) == 0;

                if ($sixCols && $fourCols && $twoCols) {
                ?><div class="clearfix visible-lg visible-md visible-sm visible-xs"></div><?php
                } 
                elseif ($sixCols && $twoCols) {
                ?><div class="clearfix visible-lg visible-md hidden-sm visible-xs"></div><?php
                }  
                elseif ($fourCols && $twoCols) {
                ?><div class="clearfix hidden-lg hidden-md visible-sm visible-xs"></div><?php
                }  
                elseif ($sixCols) {
                ?><div class="clearfix visible-lg visible-md hidden-sm hidden-xs"></div><?php
                } 
                elseif ($fourCols) {
                ?><div class="clearfix hidden-lg hidden-md visible-sm hidden-xs"></div><?php
                } 
                elseif ($twoCols) {
                ?><div class="clearfix hidden-lg hidden-md hidden-sm visible-xs"></div><?php
                }
                $index++; 
                ?>

                @empty
                @endforelse
            </div>
        </div>
    </section>
