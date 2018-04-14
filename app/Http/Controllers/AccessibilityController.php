<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;


class AccessibilityController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manageCookie(Request $request)
    {     
        if($request->input('accessible') == "TRUE")
        {
           return redirect($request->input('url'))->withCookie(cookie('accessible', 'accessible', 262800));  
        }
        return redirect($request->input('url'))->withCookie(cookie('accessible', NULL, 262800)); 
    }
}
