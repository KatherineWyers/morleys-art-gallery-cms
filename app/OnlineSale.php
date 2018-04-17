<?php

namespace App;

use App\Artwork;
use App\User;


use Illuminate\Database\Eloquent\Model;

class OnlineSale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['purchaser_name', 'purchaser_email', 'customer_id', 'artwork_id'];

	/**
	* Get the artwork
	*/
	public function artwork() {
		return $this->belongsTo('App\Artwork');
	}

	/**
	* Get the customer
	*/
	public function customer() {
		return $this->belongsTo('App\User', 'customer_id'); 
	}

}
