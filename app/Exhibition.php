<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'start_date', 'end_date', 'desc_1', 'img_1', 'img_2', 'created_at', 'updated_at'];

    public function scopeCurrent($query) 
    {
    	$date_today = date('Y-m-d');
    	return $query->where('start_date', '<=', $date_today)->where('end_date', '>=', $date_today)->orderBy('start_date', 'asc');
    }

    public function scopeInTheNext365Days($query) 
    {
    	$date_one_year_in_the_future = date('Y-m-d', strtotime('+1 year'));
    	$date_tomorrow = date('Y-m-d', strtotime('+1 day'));
    	return $query->whereBetween('start_date', [$date_tomorrow, $date_one_year_in_the_future])->orderBy('start_date', 'asc');
    }
}
