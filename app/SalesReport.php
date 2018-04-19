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

    /**
     * itemCount
     *
     * @return integer
     */
    public function itemCount()
    {
        return $this->item_count;
    }

    /**
     * salesFigure
     *
     * @return integer
     */
    public function salesFigure()
    {
        return $this->sales_figure;
    }

}
