<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * isAdmin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->role == 'Admin')
        {
            return true;
        }
        return false;
    }

    /**
     * isManager
     *
     * @return boolean
     */
    public function isManager()
    {
        if ($this->role == 'Manager')
        {
            return true;
        }
        return false;
    }

        

    /**
    * Get the sales_reports
    */
    public function sales_report($year, $month) {
        $sales_figure = 0;
        $item_count = 0;

        $sales = DB::table('sales')->where('seller_id', $this->id)->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        foreach($sales as $sale){

            $sales_figure = $sale->amount + $sales_figure;
            $item_count++;
        }
        $sales_report = new SalesReport(['seller_id' => $this->id, 'year' => $year, 'month' => $month, 'item_count' => $item_count, 'sales_figure' => $sales_figure]);
        return $sales_report;
    }
}
