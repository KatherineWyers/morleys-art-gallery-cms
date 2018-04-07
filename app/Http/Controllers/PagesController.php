<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\Exhibition;
use App\NewsArticle;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;


class PagesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontpage(Request $request)
    {        
        $featured_artworks=Artwork::orderBy('created_at', 'desc')->limit(6)->get();
        $current_exhibitions=Exhibition::current()->limit(2)->get();
        $latest_news_articles=NewsArticle::orderBy('created_at', 'desc')->limit(2)->get();
        $response = response()->view('web-portal.frontpage', compact('featured_artworks', 'current_exhibitions', 'latest_news_articles'));
        return $this->handleVisit($request, $response);
    }

    private function handleVisit(Request $request, Response $response){
        $visitor_id = $request->cookie('visitor_id');
        if(is_null($visitor_id)) {
            //log visit by new visitor and set cookie
            $visitor_id = DB::table('visits')->max('visitor_id') + 1;
            $cookie_notification = "We use cookies to ensure that we give you the best experience on our website. If you continue to use the website, we'll assume that you are happy to receive cookies on the Morley's website.";
            \Session::flash('flash_message',$cookie_notification);
            return redirect($request->url())->withCookie(cookie('visitor_id', $visitor_id, 262800));//redirect to this same page without creating a visit
        } else {
            //log visit by cookied visitor
            Visit::create(['visitor_id' => $visitor_id, 'url' => $request->url()]);//create new visit entry
            $response->withCookie(cookie('visitor_id', $visitor_id, 262800));//update the cookie with the new timer
        }
        return $response;
    }

}
