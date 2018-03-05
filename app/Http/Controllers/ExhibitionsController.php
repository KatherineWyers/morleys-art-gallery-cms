<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exhibition;

class ExhibitionsController extends Controller
{
    public function index()
    {        
        $current_exhibitions=Exhibition::current()->get();
        $exhibitions_in_the_next_365_days=Exhibition::inthenext365days()->get();
        return view('web-portal.exhibitions.index', compact('current_exhibitions', 'exhibitions_in_the_next_365_days'));
    }

    public function indexByYear($yyyy)
    {        
        $exhibitions_by_year=Exhibition::whereYear('start_date', $yyyy)->get();
        return view('web-portal.exhibitions.by-year.index', compact('yyyy', 'exhibitions_by_year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exhibition=Exhibition::find($id);
        return view('web-portal/exhibitions/show', compact('exhibition'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
