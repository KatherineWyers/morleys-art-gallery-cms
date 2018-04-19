<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalSalesReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['year', 'month', 'tax_rate'];

    /**
     * sales
     *
     * @return integer
     */
    public function sales()
    {
        $sales = 0;
        $sales_objects = Sale::inMonth($this->year, $this->month)->get();
        foreach($sales_objects as $sale){
            $sales = $sales + $sale->amount;
        }
        return $sales;
    }

    /**
     * online_sales
     *
     * @return integer
     */
    public function onlineSales()
    {
        $online_sales = 0;
        $online_sales_objects = OnlineSale::inMonth($this->year, $this->month)->get();

        foreach($online_sales_objects as $online_sale){
            $online_sales = $online_sales + $online_sale->artwork->price;
        }
        return $online_sales;
    }

    /**
     * total_sales
     *
     * @return integer
     */
    public function totalSales()
    {
        return $this->sales() + $this->onlineSales();
    }

    /**
     * tax_rate
     *
     * @return integer
     */
    public function taxRate()
    {
        return $this->tax_rate;
    }

    /**
     * tax_liability
     *
     * @return integer
     */
    public function taxLiability()
    {
        return MathHelper::calculatePercentageOfValue($this->totalSales(), $this->taxRate());
    }

    /**
     * total_sales_less_tax_liability
     *
     * @return integer
     */
    public function totalSalesLessTaxLiability()
    {
        return $this->totalSales() - $this->taxLiability();
    }

}
