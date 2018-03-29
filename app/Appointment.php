<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone_number', 'email', 'artwork_id', 'datetime', 'created_at', 'updated_at'];

    /**
     * Get the artwork    
     */
    public function artwork() 
    {
      return $this->belongsTo('App\Artwork');
    }

    public function datetime()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime, 'Europe/London');
    }

    public function scopeOnDate($query, $date) 
    {
        return $query->whereDate('datetime', '=', $date)->orderBy('datetime', 'asc');
    }
}
