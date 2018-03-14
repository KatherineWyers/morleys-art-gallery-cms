@extends('web-portal.navigation.standardpage')
@section('content')

    <section id="item" class="container-fluid">
        <div class="wrapper">
            <div class="row">
                <div class="col-xs-12 col-md-6">                   
                    @guest
                    @else
                    <p><a href="/artworks/{{ $artwork->id }}/edit" class="btn btn-lg btn-warning">Edit</a></p>
                    @endguest
                    <img src="/img/artworks/{{ $featured_img }}" class="img-responsive">

                </div>
                <div class="col-xs-4 col-sm-6">
                    <h1>{{ $artwork->title }}</h1>
                    <h2><a href="/artists/{{ $artwork->artist->id }}">{{ $artwork->artist->name }}</a></h2>
                    <p>
                        @forelse($artwork->categories as $category)
                            <a href="/artworks/c/{{ $category->id }}">{{ $category->title }}</a>, 
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
                    <p>{!! nl2br(e($artwork->desc_1)) !!}</p>

                    <h2>Would you like more details?</h2>
                    <p>Contact us by phone or via Skype to speak to a member of our team and arrange a private viewing</p>


                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                      Call, LiveChat or Skype
                    </button>

                    <div class="row">
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/1"><img src="/img/artworks/{{ $artwork->img_1 }}" class="img-responsive"></a>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/2"><img src="/img/artworks/{{ $artwork->img_2 }}" class="img-responsive"></a>
                        </div>
                        <div class="col-xs-6 col-sm-4">
                            <a href="/artworks/{{ $artwork->id }}/3"><img src="/img/artworks/{{ $artwork->img_3 }}" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Contact Us about "{{ $artwork->title }}"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <h2>Contact Us to book an Appointment</h2>
                <p>
                    Phone: <br />+44 2049 12345678
                </p>

                <p>
                    1 Main Street, <br />Straford-upon-Avon, <br />AV12 DX3, <br />United Kingdom
                </p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <h2>Call or LiveChat on Skype</h2>
                <p>
                    <script type="text/javascript" src="https://secure.skypeassets.com/i/scom/js/skype-uri.js"></script>
                    <div id="SkypeButton_Call_live:contact_48907_1">
                     <script type="text/javascript">
                     Skype.ui({
                     "name": "chat",
                     "element": "SkypeButton_Call_live:contact_48907_1",
                     "participants": ["live:contact_48907"],
                     "imageSize": 32
                     });
                     </script>
                    </div>

                    <div id="SkypeButton_Call_live:contact_48907_1">
                     <script type="text/javascript">
                     Skype.ui({
                     "name": "call",
                     "element": "SkypeButton_Call_live:contact_48907_1",
                     "participants": ["live:contact_48907"],
                     "imageSize": 32
                     });
                     </script>
                    </div>
                </p>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
