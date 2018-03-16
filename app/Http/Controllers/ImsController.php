<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;

class ImsController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {        
        return view('ims.home');
    }


}
