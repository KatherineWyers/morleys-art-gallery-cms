<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsArticle;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;

class NewsArticlesController extends Controller
{
    public function index(Request $request)
    {        
        $news_articles=NewsArticle::orderBy('created_at', 'desc')->paginate(8);
        $response = response()->view('web-portal.news_articles.index', compact('news_articles'));
        return $this->handleVisit($request, $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $news_article=NewsArticle::find($id);
        $response = response()->view('web-portal.news_articles.show', compact('news_article'));
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
