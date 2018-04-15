<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsArticle;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;
use App\VisitHandler;

class NewsArticlesController extends Controller
{
    public function index(Request $request)
    {        
        $news_articles=NewsArticle::orderBy('created_at', 'desc')->paginate(8);
        $response = response()->view('web-portal.news_articles.index', compact('news_articles'));
        return VisitHandler::handleVisit($request, $response);
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
        return VisitHandler::handleVisit($request, $response);
    }

}
