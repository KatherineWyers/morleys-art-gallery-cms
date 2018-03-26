<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timeslot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime'];

    public function getAppointment()
    {
        return Appointment::where('datetime', '=', $this->datetime)->first();
    }

    public function isAvailable() 
        {
        if(($this->hasAppointment())||($this->isHoliday())||($this->datetime()->isPast()))
        {
            return FALSE;
        }
        return TRUE;
    }

    // dates can be disabled by setting them as holiday
    // timeslots cannot be assigned during holidays
    private function isHoliday()
    {
        return FALSE;
    }

    private function hasAppointment()
    {
        if($this->getAppointment() == NULL)
        {
            return FALSE;
        }
        return TRUE; 
    }

    public function datetime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime, 'Europe/London');
    }
}