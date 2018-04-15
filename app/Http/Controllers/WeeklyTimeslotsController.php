<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeeklyTimeslot;

class WeeklyTimeslotsController extends Controller
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
        $weekly_timeslots = WeeklyTimeslot::orderBy('id', 'asc')->get();
        return view('ims.weekly_timeslots.index', compact('weekly_timeslots'));
    }


    /**
     * Show the form for editing the set of timeslots.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $weekly_timeslots = WeeklyTimeslot::orderBy('id', 'asc')->get();
        return view('ims.weekly_timeslots.edit', compact('weekly_timeslots'));
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
        $weekly_timeslots = WeeklyTimeslot::all();
        // set each timeslot to unchecked
        foreach($weekly_timeslots as $weekly_timeslot)
        {
            $weekly_timeslot->checked = FALSE;
            $weekly_timeslot->save();
        }

        // check timeslots that are checked in form
        foreach($request->input('weekly_timeslots') as $weekly_timeslot_id)
        {
            $weekly_timeslot = WeeklyTimeslot::find($weekly_timeslot_id);
            $weekly_timeslot->checked = TRUE;
            $weekly_timeslot->save();
        }

        return redirect('/ims/weekly_timeslots');
    }

}
