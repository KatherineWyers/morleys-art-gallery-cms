<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone_number', 'artwork_id', 'seller_id', 'amount'];

	/**
	* Get the artwork
	*/
	public function artwork() {
		return $this->belongsTo('App\Artwork');
	}

	/**
	* Get the customer
	*/
	public function seller() {
		return $this->belongsTo('App\User', 'seller_id'); 
	}

    public static function getArrayOfSalesAndOnlineSales()
    {
		$in_person_sales = DB::table('sales')
                     ->select(DB::raw('"Sale" as type, sales.id, sales.created_at as datetime, sales.amount as amount, artworks.title as artwork_title'))
                     ->join('artworks', 'artworks.id', '=', 'sales.artwork_id');

		$sales_and_online_sales = DB::table('online_sales')
                     ->select(DB::raw('"Online Sale" as type, online_sales.id, online_sales.created_at as datetime, artworks.price as amount, artworks.title as artwork_title'))
                     ->join('artworks', 'artworks.id', '=', 'online_sales.artwork_id')
                     ->union($in_person_sales)
                     ->orderBy('datetime', 'desc')
                     ->get();
    	return $sales_and_online_sales;
    }

    public function scopeInMonth($query, $year, $month) 
    {
        return $query->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
    }
}
