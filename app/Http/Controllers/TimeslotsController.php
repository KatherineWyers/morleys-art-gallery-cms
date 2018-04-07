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

class TimeslotsController extends Controller
{

    public function indexForDate(Request $request, $artwork_id, $date = 5, $month = 4, $year = 2018)
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
            if($timeslot->isAvailable())
            {
            array_push($timeslots, $timeslot);
            }                
        }

        $artwork = Artwork::find($artwork_id);

        $response = response()->view('web-portal.timeslots.index', compact('timeslots', 'artwork', 'calendar'));
        return $this->handleVisit($request, $response);
    }

    private function handleVisit(Request $request, Response $response){
        $visitor_id = $request->cookie('visitor_id');
        if(is_null($visitor_id)) {
            //log visit by new visitor and set cookie
            $visitor_id = DB::table('visits')->max('visitor_id') + 1;
            $cookie_notification = "We use cookies to ensure that we give you the best experience on our website. If you continue to use the website, we'll assume that you are happy to receive cookies on the Morley's website.";
            \Session::flash('flash_message',$cookie_notification);
            return redirect($request->url())->withCookie(cookie('visitor_id', $visitor_id, 262800));//redirect to this same page without creating a visit
        } else {
            //log visit by cookied visitor
            Visit::create(['visitor_id' => $visitor_id, 'url' => $request->url()]);//create new visit entry
            $response->withCookie(cookie('visitor_id', $visitor_id, 262800));//update the cookie with the new timer
        }
        return $response;
    }
}
