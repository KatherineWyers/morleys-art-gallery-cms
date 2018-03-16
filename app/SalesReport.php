<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seller_id', 'year', 'month', 'item_count', 'sales_figure'];

    /**
     * toString
     *
     * @return string
     */
    public function toString()
    {
    	return 'Month: ' . $this->year . '-' . $this->month . ', Total Items Sold: ' . $this->item_count . ', Sales: ' . $this->sales_figure;
    }

}
