<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Category;

class ArtworksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($category_id = 0)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        if($category_id >= 1 && $category_id <= 6){
            $category = Category::find($category_id);
            $category_title = ': ' . $category->title;
            $artworks = $category->artworks()->paginate(50);
        } else {
            $artworks = Artwork::orderBy('created_at', 'desc')->paginate(50);
            $category_title = '';
        }
        return view('web-portal.artworks.index', compact('artworks', 'categories', 'category_title'));
    }

    public function indexUnderMaxPrice($max_price = 2500)
    {
        $categories = Category::orderBy('id', 'asc')->get();
        $category_title = ': Under £' . $max_price;
        $artworks = Artwork::where('price', '<=', $max_price)->orderBy('created_at', 'desc')->paginate(50);
        return view('web-portal.artworks.index', compact('artworks', 'categories', 'category_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artwork=Artwork::find($id);
        return view('web-portal/artworks/show', compact('artwork'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
