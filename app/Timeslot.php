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
    protected $fillable = ['day', 'hour', 'checked'];

    public function dayHour() 
    {
        return $this->day . " - " . $this->hour . ":00";
    }
}