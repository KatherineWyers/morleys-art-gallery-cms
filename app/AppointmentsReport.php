<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AppointmentsReport;
use Illuminate\Support\Facades\DB;
use App\MathHelper;

class AppointmentsReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['year', 'month', 'appointments_count', 'appointments_led_to_sale_count'];

    /**
    * Get the sales_reports
    */
    public static function getReport($year, $month) {
        $appointments_count = 0;
        $appointments_led_to_sale_count = 0;

        $appointments = DB::table('appointments')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->get();

        foreach($appointments as $appointment){
            if($appointment->led_to_sale == TRUE)
            {
                $appointments_led_to_sale_count++;
            }
            $appointments_count++;
        }
        $appointments_report = new AppointmentsReport(['year' => $year, 'month' => $month, 'appointments_count' => $appointments_count, 'appointments_led_to_sale_count' => $appointments_led_to_sale_count]);

        return $appointments_report;
    }


    /**
     * toString
     *
     * @return string
     */
    public function toString()
    {
    	return 'Month: ' . $this->year . '-' . $this->month . ', Total Appointments: ' . $this->appointments_count . ', Appointments Led To Sale Count: ' . $this->appointments_led_to_sale_count . ' Appointments Led To Sale Percentage: ' . $this->appointmentsLedToSalePercentage();
    }

    /**
     * appointmentsCount
     *
     * @return integer
     */
    public function appointmentsCount()
    {
        return $this->appointments_count;
    }

    /**
     * appointmentsLedToSaleCount
     *
     * @return integer
     */
    public function appointmentsLedToSaleCount()
    {
        return $this->appointments_led_to_sale_count;
    }


    /**
     * appointmentsLedToSaleCount
     *
     * @return integer
     */
    public function appointmentsLedToSalePercentage()
    {
        return MathHelper::calculatePercentage($this->appointments_led_to_sale_count, $this->appointments_count);
    }

}
