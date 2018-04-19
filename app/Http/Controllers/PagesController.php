<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Exhibition;
use App\NewsArticle;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;
use App\VisitHandler;


class PagesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontpage(Request $request)
    {        
        $featured_artworks=Artwork::visible()->orderBy('created_at', 'desc')->limit(6)->get();
        $current_exhibitions=Exhibition::current()->limit(2)->get();
        $latest_news_articles=NewsArticle::orderBy('created_at', 'desc')->limit(2)->get();
        $response = response()->view('web-portal.frontpage', compact('featured_artworks', 'current_exhibitions', 'latest_news_articles'));
        return VisitHandler::handleVisit($request, $response);
    }
}
