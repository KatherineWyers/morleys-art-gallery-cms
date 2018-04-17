<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Artist;
use App\Artwork;
use App\Category;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;
use App\VisitHandler;

class ArtworksController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin', ['except' => ['index', 'indexUnderMaxPrice', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_id = 0)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        if($category_id >= 1 && $category_id <= 6){
            $category = Category::find($category_id);
            $category_title = ': ' . $category->title;
            $artworks = $category->artworks()->visible()->paginate(50);
        } else {
            $artworks = Artwork::visible()->orderBy('created_at', 'desc')->paginate(50);
            $category_title = '';
        }
        $response = response()->view('web-portal.artworks.index', compact('artworks', 'categories', 'category_title'));
        return VisitHandler::handleVisit($request, $response);
    }

    public function indexUnderMaxPrice(Request $request, $max_price = 2500)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $category_title = ': Under £' . $max_price;
        $artworks = Artwork::visible()->where('price', '<=', $max_price)->orderBy('created_at', 'desc')->paginate(50);
        $response = response()->view('web-portal.artworks.index', compact('artworks', 'categories', 'category_title'));
        return VisitHandler::handleVisit($request, $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $artists = Artist::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('id', 'asc')->get();
        return view('web-portal.artworks.create', compact('artists', 'categories'));
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
            'title' => 'required|max:30',
            'artist_id' => 'required|exists:artists,id',
            'year_created' => 'required|integer|min:1500|max:2050',
            'desc_1' => 'required|max:1000',
            'medium' => 'required|max:30',
            'width_cm' => 'required|numeric',
            'height_cm' => 'required|numeric',
            'width_in' => 'required|numeric',
            'height_in' => 'required|numeric',
            'price' => 'required|numeric',
            'img_1' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_2' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_3' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_sq' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=300,height=300',
        ]);


        $artwork=$request->all();
        $artwork = Artwork::create($artwork);

        if(!is_null(Input::file('img_1'))) {
            $file_img_1 = Input::file('img_1');
            $filename_img_1 = $artwork->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_1->move($destinationPath, $filename_img_1);
            $artwork->img_1 = $artwork->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
        }
        
        $artwork->save();

        if(!is_null(Input::file('img_2'))) {
            $file_img_2 = Input::file('img_2');
            $filename_img_2 = $artwork->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_2->move($destinationPath, $filename_img_2);
            $artwork->img_2 = $artwork->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
        }

        $artwork->save();

        if(!is_null(Input::file('img_3'))) {
            $file_img_3 = Input::file('img_3');
            $filename_img_3 = $artwork->id . '-img_3.' . $file_img_3->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_3->move($destinationPath, $filename_img_3);
            $artwork->img_3 = $artwork->id . '-img_3.' . $file_img_3->getClientOriginalExtension();
        }      

        $artwork->save();

        if(!is_null(Input::file('img_sq'))) {
            $file_img_sq = Input::file('img_sq');
            $filename_img_sq = $artwork->id . '-img_sq.' . $file_img_sq->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_sq->move($destinationPath, $filename_img_sq);
            $artwork->img_sq = $artwork->id . '-img_sq.' . $file_img_sq->getClientOriginalExtension();
        }      

        $artwork->save();

        // assign the categories to the artwork
        foreach($request->input('categories') as $category_id)
        {
            $category = Category::find($category_id);
            $artwork->categories()->save($category);
        }

        return redirect('/artworks/' . $artwork->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id, $img = 1)
    {
        $artwork=Artwork::find($id);

        if($artwork->visible==FALSE) {
            \Session::flash('flash_message', 'The requested artwork is no longer available');
            return redirect('/artworks');
        }

        switch ($img){
            case 1:
                $featured_img = $artwork->img_1;
                break;
            case 2:
                $featured_img = $artwork->img_2;
                break;
            case 3:
                $featured_img = $artwork->img_3;
                break;
            default:
                $featured_img = $artwork->img_1;
                break;
        }
        
        $response = response()->view('web-portal/artworks/show', compact('artwork', 'featured_img'));
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
        $artwork=Artwork::find($id);
        $artists = Artist::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('id', 'asc')->get();
        return view('web-portal.artworks.edit', compact('artwork', 'artists', 'categories'));
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
            'title' => 'required|max:30',
            'artist_id' => 'required|exists:artists,id',
            'year_created' => 'required|integer|min:1500|max:2050',
            'desc_1' => 'required|max:1000',
            'medium' => 'required|max:30',
            'width_cm' => 'required|numeric',
            'height_cm' => 'required|numeric',
            'width_in' => 'required|numeric',
            'height_in' => 'required|numeric',
            'price' => 'required|numeric',
            // images are not required. If they are null, they will not be updated later
            'img_1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_2' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_3' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=400,min_height=400',
            'img_sq' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=300,height=300',
        ]);

        $artworkUpdate=$request->all();
        $artwork=Artwork::find($id);
        $artwork->update($artworkUpdate);

        if(!is_null(Input::file('img_1'))) {
            $file_img_1 = Input::file('img_1');
            $filename_img_1 = $artwork->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_1->move($destinationPath, $filename_img_1);
            $artwork->img_1 = $artwork->id . '-img_1.' . $file_img_1->getClientOriginalExtension();
        }
        
        $artwork->save();

        if(!is_null(Input::file('img_2'))) {
            $file_img_2 = Input::file('img_2');
            $filename_img_2 = $artwork->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_2->move($destinationPath, $filename_img_2);
            $artwork->img_2 = $artwork->id . '-img_2.' . $file_img_2->getClientOriginalExtension();
        }

        $artwork->save();

        if(!is_null(Input::file('img_3'))) {
            $file_img_3 = Input::file('img_3');
            $filename_img_3 = $artwork->id . '-img_3.' . $file_img_3->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_3->move($destinationPath, $filename_img_3);
            $artwork->img_3 = $artwork->id . '-img_3.' . $file_img_3->getClientOriginalExtension();
        }      

        $artwork->save();

        if(!is_null(Input::file('img_sq'))) {
            $file_img_sq = Input::file('img_sq');
            $filename_img_sq = $artwork->id . '-img_sq.' . $file_img_sq->getClientOriginalExtension();
            $destinationPath = 'img/artworks';
            $uploadSuccess = $file_img_sq->move($destinationPath, $filename_img_sq);
            $artwork->img_sq = $artwork->id . '-img_sq.' . $file_img_sq->getClientOriginalExtension();
        }      

        $artwork->save();

        //delete all categories for the artwork
        DB::table('artwork_categories')->where('artwork_id', $artwork->id)->delete();

        // assign the categories to the artwork
        foreach($request->input('categories') as $category_id)
        {
            $category = Category::find($category_id);
            $artwork->categories()->save($category);
        }
        return redirect('/artworks/' . $artwork->id);
    }
}
