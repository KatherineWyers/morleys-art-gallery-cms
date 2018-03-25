<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime', 'appointment'];

    public function isAvailable() 
    {
        return !(($this->hasAppointment) && !($this->isHoliday()));
    }

    // dates can be disabled by setting them as holiday
    // timeslots cannot be assigned during holidays
    private function isHoliday()
    {
        return FALSE;
    }

    private function hasAppointment()
    {
        return ($this->appointment != NULL);  
    }
}