<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timeslot;

class TimeslotsController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin');
    }

    public function index()
    {        
        $timeslots = Timeslot::orderBy('id', 'asc')->get();
        return view('ims.timeslots.index', compact('timeslots'));
    }


    /**
     * Show the form for editing the set of timeslots.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $timeslots = Timeslot::orderBy('id', 'asc')->get();
        return view('ims.timeslots.edit', compact('timeslots'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $timeslots = Timeslot::all();
        // set each timeslot to unchecked
        foreach($timeslots as $timeslot)
        {
            $timeslot->checked = FALSE;
            $timeslot->save();
        }

        // check timeslots that are checked in form
        foreach($request->input('timeslots') as $timeslot_id)
        {
            $timeslot = Timeslot::find($timeslot_id);
            $timeslot->checked = TRUE;
            $timeslot->save();
        }

        return redirect('/ims/timeslots');
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
