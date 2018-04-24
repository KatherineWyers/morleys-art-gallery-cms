<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeeklyTimeslot extends Model
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

    public function scopeChecked($query) 
    {
        return $query->where('checked', '=', TRUE)->orderBy('id', 'asc');
    }

    public function scopeOnDay($query, $day) 
    {
        return $query->where('day', '=', $day)->where('checked', '=', TRUE)->orderBy('hour', 'asc');
    }
}