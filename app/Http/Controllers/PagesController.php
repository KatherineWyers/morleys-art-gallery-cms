<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Exhibition;
use App\NewsArticle;

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
        $current_exhibitions=Exhibition::current()->get();
        $latest_news_articles=NewsArticle::orderBy('created_at', 'desc')->limit(2)->get();
        return view('web-portal.frontpage', compact('featured_artworks', 'current_exhibitions', 'latest_news_articles'));
    }


}
