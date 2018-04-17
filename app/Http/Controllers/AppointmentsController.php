<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Artwork;
use App\Timeslot;
use App\Appointment;
use App\Calendar;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Visit;

use App\StringHandler;
use App\VisitHandler;

class AppointmentsController extends Controller
{

    /**
     * Enforce middleware.
     */
    public function __construct()
    {
        $this->middleware('ismanageroradmin', ['except' => ['create', 'store']]);
    }

    public function indexForDate($date = 26, $month = 3, $year = 2018)
    {        

        $calendar = new Calendar;
        $calendar->setDatetime($date, $month, $year);
        $appointments = Appointment::onDate($calendar->datetime->toDateString())->get();
        return view('ims.appointments.index', compact('appointments', 'calendar'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $artwork_id, $year, $month, $date, $hour)
    {
        $artwork = Artwork::find($artwork_id);
        $datetime = $year . '-' . StringHandler::addLeadingZeroFrom0To99($month) . '-' . StringHandler::addLeadingZeroFrom0To99($date) . ' ' .  StringHandler::addLeadingZeroFrom0To99($hour) . ':00:00';
        $response = response()->view('web-portal.appointments.create', compact('artwork', 'datetime'));
        return VisitHandler::handleVisit($request, $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30',
            'phone_number' => 'max:100',
            'email' => 'max:100',
            'artwork_id' => 'required|exists:artworks,id',
            'datetime' => 'date_format:Y-m-d H:i:s'
        ]);

        // confirm that timeslot is still available
        $timeslot = new Timeslot;

        $timeslot->datetime = $request->input('datetime');

        if($timeslot->isAvailable() == FALSE)
        {
            return redirect('/timeslots/' . $request->input('artwork_id'));
        }
        
        $appointment=$request->all();
        $appointment = Appointment::create($appointment);

        return redirect('/artworks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $appointment=Appointment::find($id);
        return view('ims.appointments.delete', compact('appointment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Appointment::where('id',$id)->delete();
        return redirect('/appointments');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsSale($id)
    {
        $appointment=Appointment::find($id);
        $appointment->led_to_sale = TRUE;
        $appointment->save();
        \Session::flash('flash_message', 'The appointment was marked as leading to a sale');
        return redirect('/ims/appointments');
    }


}
