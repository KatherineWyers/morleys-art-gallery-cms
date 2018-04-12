<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineSale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['purchaser_name', 'purchaser_email', 'customer_id', 'artwork_id'];
}
