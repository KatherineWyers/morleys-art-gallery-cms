@extends('web-portal.navigation.standardpage')
@section('content')
    <section id="item" class="container-fluid">
        <div class="wrapper">
            <h1>Artworks {{ $category_title }}</h1>   
            @guest
            @else
                @if  (Auth::user()->isManagerOrAdmin() == TRUE)
                    <p><a href="/artworks/create" class="btn btn-lg btn-warning">+ Add New Artwork</a></p>
                @endif
            @endguest         
            <p>
                <a href="/artworks/c/0">All</a> | 
                @forelse($categories as $category)
                <a href="/artworks/c/{{ $category->id }}">{{ $category->title }}</a> | 
                @empty
                @endforelse
                <a href="/artworks/max-price/1000">Under £1000</a>
            </p>
            <div class="row">
                <?php $index = 1; ?>

                @forelse($artworks as $artwork)
                <div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
                    <a href="/artworks/{{ $artwork->id }}"><img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive">
                    <p>{{ $artwork->title }}</p>
                    <p>{{ $artwork->artist->name }}</p>
                    <p>Price: £{{ $artwork->price }}</p>
                    </a>
                </div>

                <?php
                $twoCols = ($index % 2) == 0;
                $fourCols  = ($index % 4) == 0;
                $sixCols = ($index % 6) == 0;

                if ($sixCols && $fourCols && $twoCols) {
                ?><div class="clearfix visible-lg visible-md visible-sm visible-xs"></div><?php
                } 
                elseif ($sixCols && $twoCols) {
                ?><div class="clearfix visible-lg hidden-md hidden-sm visible-xs"></div><?php
                }  
                elseif ($fourCols && $twoCols) {
                ?><div class="clearfix hidden-lg visible-md visible-sm visible-xs"></div><?php
                }  
                elseif ($sixCols) {
                ?><div class="clearfix visible-lg hidden-md hidden-sm hidden-xs"></div><?php
                } 
                elseif ($fourCols) {
                ?><div class="clearfix hidden-lg visible-md visible-sm hidden-xs"></div><?php
                } 
                elseif ($twoCols) {
                ?><div class="clearfix hidden-lg hidden-md hidden-sm visible-xs"></div><?php
                }
                $index++; 
                ?>

                @empty
                @endforelse
            </div>

            {{ $artworks->links()}}
        </div>
    </section>
@endsection
