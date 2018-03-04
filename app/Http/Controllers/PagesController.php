<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;

class PagesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontpage()
    {        
        $featured_artworks=Artwork::orderBy('created_at', 'desc')->limit(6)->get();
        return view('web-portal.frontpage', compact('featured_artworks'));
    }


}
