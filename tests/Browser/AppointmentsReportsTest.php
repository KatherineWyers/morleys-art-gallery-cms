<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Carbon\Carbon;
use App\AppointmentsReport;
use Illuminate\Support\Facades\DB;

use App\Artwork;
use App\Appointment;
use App\User;
use App\MathHelper;
use App\Artist;

class AppointmentsReportsTest extends DuskTestCase
{
    /**
     * System test for the appointments reporting process
     * @group ims
     * @group appointments-reports
     * @return void
     */
    public function test_Should_UpdateAppointmentsReport_When_StaffMarksAppointmentAsLedToSale()
    {
        //check initial values
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $appointments_report = AppointmentsReport::getReport($year, $month);
        $appointments_count_before_this_sale = $appointments_report->appointmentsCount();
        $appointments_led_to_sale_count_before_this_sale = $appointments_report->appointmentsLedToSaleCount();
        $artwork = Artwork::where('visible', TRUE)->first();

        //create an unsuccessful appointment
        $appointment_unsuccessful = factory(Appointment::class)->create(['name' => 'Test Name', 'phone_number' => '0123456', 'email' => 'test.name@gmail.com', 'datetime' => Carbon::now()->format('Y-m-d h:m:s'), 'artwork_id' => $artwork->id]);

        //create a successful appointment
        $appointment_successful = factory(Appointment::class)->create(['name' => 'Test Name', 'phone_number' => '0123456', 'email' => 'test.name@gmail.com', 'datetime' => Carbon::now()->format('Y-m-d h:m:s'), 'artwork_id' => $artwork->id, 'led_to_sale' => TRUE]);

        //check the values after appointments created
        $appointments_count_after_this_sale = $appointments_report->appointmentsCount();
        $appointments_led_to_sale_count_after_this_sale = $appointments_report->appointmentsLedToSaleCount();
        $appointments_led_to_sale_percentage_after_this_sale = $appointments_report->appointmentsLedToSalePercentage();

        //set the expected sales report
        $expected_appointments_count = $appointments_count_before_this_sale + 2;
        $expected_appointments_led_to_sale_count = $appointments_led_to_sale_count_before_this_sale + 1;
        $expected_appointments_led_to_sale_percentage = MathHelper::calculatePercentage($expected_appointments_led_to_sale_count, $expected_appointments_count);

        $appointments_report_string = 'Month: ' . $year . '-' . $month . ', Total Appointments: ' . $expected_appointments_count . ', Appointments Led To Sale Count: ' . $expected_appointments_led_to_sale_count . ' Appointments Led To Sale Percentage: ' . $expected_appointments_led_to_sale_percentage . '%';

        $this->loginAsManager();
        $this->browse(function ($browser) use($appointments_report_string) {
            $browser->resize(1366, 768)
                    ->visit('/ims/appointments/reports')
                    ->assertSee($appointments_report_string);
        });
        $this->logout();

        DB::table('appointments')->where('id', '=', $appointment_unsuccessful->id)->delete();
        DB::table('appointments')->where('id', '=', $appointment_successful->id)->delete();

    }

    /**
     * @group ims
     * @group appointments-reports
     * @return void
     */
    public function test_Should_DisplayLinkToAppointmentsReports_When_ManagerViewsAppointments()
    {
        $this->loginAsManager();
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/ims')
                    ->clickLink("Appointments")
                    ->assertSee('Appointments Schedule')
                    ->assertSee('Appointments Reports')
                    ->clickLink('Appointments Reports')
                    ->assertPathIs('/ims/appointments/reports')
                    ->assertSee('Appointments Reports')
                    ->assertSee('This Month')
                    ->assertSee('Last Month')
                    ->clickLink('Appointments Schedule')
                    ->assertPathIs('/ims/appointments');
        });
        $this->logout();
    }


    private function loginAsManager() 
    {
        $user = User::Managers()->first();
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user);
        }); 
        return $user; 
    }

    private function logout() 
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }


}
