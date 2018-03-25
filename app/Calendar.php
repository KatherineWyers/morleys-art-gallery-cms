<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Calendar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime'];

    public function setDatetime($date, $month, $year)
    {
        $this->datetime = Carbon::create($year, $month, $date, 0, 0, 0, 'Europe/London');
    }

    public function firstDayOfMonth()
    {
        $first_day_of_month = $this->datetime;
        $first_day_of_month->day = 1;
        return $first_day_of_month;
    }

    public function daysInMonth()
    {
        return cal_days_in_month(CAL_GREGORIAN,$this->datetime->month,$this->datetime->year);
    }

    public function dayTitle()
    {

        switch ($this->datetime->dayOfWeek) {
            case 1:
                return 'Monday';
                break;
            case 2:
                return 'Tuesday';
                break;
            case 3:
                return 'Wednesday';
                break;
            case 4:
                return 'Thursday';
                break;
            case 5:
                return 'Friday';
                break;
            case 6:
                return 'Saturday';
                break;
            case 0:
                return 'Sunday';
                break;
            default:
                return '';
                break;
        } 
    }

    public function monthTitle()
    {
        switch ($this->datetime->month) {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
            default:
                return '';
                break;
        } 
    }


}