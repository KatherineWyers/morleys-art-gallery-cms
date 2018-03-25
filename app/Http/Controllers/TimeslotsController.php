<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WeeklyTimeslot;
use App\Timeslot;
use Carbon\Carbon;
use App\Artwork;
use App\Calendar;

class TimeslotsController extends Controller
{

    public function indexForDate($artwork_id, $date = 26, $month = 3, $year = 2018)
    {        

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

            // get appointment_id for the timeslot datetime, or set as NULL
            $timeslot->appointment_id = NULL;
            array_push($timeslots, $timeslot);
        }

        $artwork = Artwork::find($artwork_id);

        return view('web-portal.timeslots.index', compact('timeslots', 'artwork', 'calendar'));
    }

    // public function indexForMonth($artwork_id, $month = 3, $year = 2018)
    // {        
    //     $days_in_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        

    //     // create array of all available timeslots
    //     $timeslots = array();
    //     for($i = 1; $i <= $days_in_month; $i++)
    //     {
    //         //clear the array
    //         $timeslots_this_date= array();
    //         $datetime = Carbon::create($year, $month, $i, 0, 0, 0, 'Europe/London');
    //         $weekly_timeslots_this_date = WeeklyTimeslot::onDay($datetime->dayOfWeek)->get();

    //         foreach($weekly_timeslots_this_date as $weekly_timeslot)
    //         {
    //             $datetime->hour = $weekly_timeslot->hour;
    //             $timeslot = new Timeslot;
    //             $timeslot->datetime = $datetime->toDateTimeString();
    //             $timeslot->appointment_id = NULL;
    //             array_push($timeslots, $timeslot);
    //         }

    //     }
    //     $artwork = Artwork::find($artwork_id);

    //     return view('web-portal.timeslots.index', compact('timeslots', 'artwork', 'days_in_month', 'date', 'month', 'year', 'month_title', 'first_day_of_month'));
    // }

}
