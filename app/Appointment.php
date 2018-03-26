<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
      public function artwork() {
        return $this->belongsTo('App\Artwork');
      }
}
