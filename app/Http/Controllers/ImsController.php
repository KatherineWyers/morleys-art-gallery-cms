<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artwork;
use App\OnlineSale;

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
        $online_sales_awaiting_collection = OnlineSale::uncollected()->get();
        return view('ims.home', compact('online_sales_awaiting_collection'));
    }
}
