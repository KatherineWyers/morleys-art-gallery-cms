<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Visit;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class VisitsController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $visits = DB::table('visits')->select('url', DB::raw('count(*) as total'))->where('created_at', '>=', Carbon::now()->subMonth())->groupBy('url')->orderBy('total', 'desc')->get();   
        return view('ims.visits.index', compact('visits'));
    }
}
