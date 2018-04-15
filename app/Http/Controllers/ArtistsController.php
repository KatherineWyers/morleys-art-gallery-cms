<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Artist;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;
use App\VisitHandler;

class ArtistsController extends Controller
{
    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin', ['except' => ['index', 'show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $artists=Artist::orderBy('name', 'desc')->get();
        $response = response()->view('web-portal.artists.index', compact('artists'));
        return VisitHandler::handleVisit($request, $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web-portal.artists.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'desc_1' => 'required|max:1000',
            'profile_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'featured_artwork_img_lg' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1240,height=700',
            'featured_artwork_img_sm' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=300,height=300',
        ]);

        $artist=$request->all();
        $artist = Artist::create($artist);

        if(!is_null(Input::file('profile_img'))) {
            $file_profile_img = Input::file('profile_img');
            $filename_profile_img = $artist->id . '-profile_img.' . $file_profile_img->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_profile_img->move($destinationPath, $filename_profile_img);
            $artist->profile_img = $artist->id . '-profile_img.' . $file_profile_img->getClientOriginalExtension();
        }
        
        $artist->save();

        if(!is_null(Input::file('featured_artwork_img_lg'))) {
            $file_featured_artwork_img_lg = Input::file('featured_artwork_img_lg');
            $filename_featured_artwork_img_lg = $artist->id . '-featured_artwork_img_lg.' . $file_featured_artwork_img_lg->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_featured_artwork_img_lg->move($destinationPath, $filename_featured_artwork_img_lg);
            $artist->featured_artwork_img_lg = $artist->id . '-featured_artwork_img_lg.' . $file_featured_artwork_img_lg->getClientOriginalExtension();
        }

        $artist->save();

        if(!is_null(Input::file('featured_artwork_img_sm'))) {
            $file_featured_artwork_img_sm = Input::file('featured_artwork_img_sm');
            $filename_featured_artwork_img_sm = $artist->id . '-featured_artwork_img_sm.' . $file_featured_artwork_img_sm->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_featured_artwork_img_sm->move($destinationPath, $filename_featured_artwork_img_sm);
            $artist->featured_artwork_img_sm = $artist->id . '-featured_artwork_img_sm.' . $file_featured_artwork_img_sm->getClientOriginalExtension();
        }       

        $artist->save();
        return redirect('/artists/' . $artist->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $artist=Artist::find($id);
        $response = response()->view('web-portal/artists/show', compact('artist'));
        return VisitHandler::handleVisit($request, $response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $artist=Artist::find($id);
        return view('web-portal.artists.edit',compact('artist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'desc_1' => 'required|max:1000',
            // images are not required. If they are null, they will not be updated later
            'profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'featured_artwork_img_lg' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1240,height=700',
            'featured_artwork_img_sm' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=300,height=300',
        ]);

        $artistUpdate=$request->all();
        $artist=Artist::find($id);
        $artist->update($artistUpdate);

        if(!is_null(Input::file('profile_img'))) {
            $file_profile_img = Input::file('profile_img');
            $filename_profile_img = $artist->id . '-profile_img.' . $file_profile_img->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_profile_img->move($destinationPath, $filename_profile_img);
            $artist->profile_img = $artist->id . '-profile_img.' . $file_profile_img->getClientOriginalExtension();
        }
        
        $artist->save();

        if(!is_null(Input::file('featured_artwork_img_lg'))) {
            $file_featured_artwork_img_lg = Input::file('featured_artwork_img_lg');
            $filename_featured_artwork_img_lg = $artist->id . '-featured_artwork_img_lg.' . $file_featured_artwork_img_lg->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_featured_artwork_img_lg->move($destinationPath, $filename_featured_artwork_img_lg);
            $artist->featured_artwork_img_lg = $artist->id . '-featured_artwork_img_lg.' . $file_featured_artwork_img_lg->getClientOriginalExtension();
        }

        $artist->save();

        if(!is_null(Input::file('featured_artwork_img_sm'))) {
            $file_featured_artwork_img_sm = Input::file('featured_artwork_img_sm');
            $filename_featured_artwork_img_sm = $artist->id . '-featured_artwork_img_sm.' . $file_featured_artwork_img_sm->getClientOriginalExtension();
            $destinationPath = 'img/artists';
            $uploadSuccess = $file_featured_artwork_img_sm->move($destinationPath, $filename_featured_artwork_img_sm);
            $artist->featured_artwork_img_sm = $artist->id . '-featured_artwork_img_sm.' . $file_featured_artwork_img_sm->getClientOriginalExtension();
        }       

        $artist->save();
        return redirect('/artists/' . $artist->id);
    }

}
