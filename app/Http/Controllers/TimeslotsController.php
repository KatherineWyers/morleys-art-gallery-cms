<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeeklyTimeslot;
use App\Timeslot;
use Carbon\Carbon;
use App\Artwork;
use App\Calendar;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;

use App\VisitHandler;

class TimeslotsController extends Controller
{

    public function indexForDate(Request $request, $artwork_id, $date = NULL, $month = NULL, $year = NULL)
    {        

        if(is_null($date)) 
        {
            $date = Carbon::now()->day;
        }       
        if(is_null($month)) 
        {
            $month = Carbon::now()->month;
        }       
        if(is_null($year)) 
        {
            $year = Carbon::now()->year;
        }

        $calendar = new Calendar;
        $calendar->setDatetime($date, $month, $year);

        $timeslots = array();
        $timeslots_this_date= array();

        $weekly_timeslots_this_date = WeeklyTimeslot::onDay($calendar->dayTitle())->get();

        foreach($weekly_timeslots_this_date as $weekly_timeslot)
        {
            $calendar->datetime->hour = $weekly_timeslot->hour;
            $timeslot = new Timeslot;
            $timeslot->datetime = $calendar->datetime->toDateTimeString();
            if($timeslot->isAvailable())
            {
            array_push($timeslots, $timeslot);
            }                
        }

        $artwork = Artwork::find($artwork_id);

        $response = response()->view('web-portal.timeslots.index', compact('timeslots', 'artwork', 'calendar'));
        return VisitHandler::handleVisit($request, $response);
    }

}
