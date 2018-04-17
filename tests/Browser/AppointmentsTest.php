<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use App\Artwork;
use App\User;
use App\Appointment;

class AppointmentsTest extends DuskTestCase
{
    


    /**
     * @group web-portal
     * @group appointments
     * @return void
     */
    public function test_Should_CreateAppointment_When_UserIsGuest()
    {
        $this->browse(function ($browser) {

            //find first artwork
            $artwork = Artwork::visible()->first();

            //ensure that the appointment does not already exist
            DB::table('appointments')->where('datetime', '=', '2100-01-01-14:00')->delete();

            //create appointment on 2100-01-01
            $browser->visit('/appointments/create/' . $artwork->id . '/2100/1/1/14')
                    ->type('name', 'Test Name')
                    ->type('phone_number', '0123456')
                    ->type('email', 'test.name@gmail.com')
                    ->click('input[type="submit"]');
        });

        //find first artwork
        $artwork = Artwork::visible()->first();

        //confirm that appointment exists with artwork and requested date
        //this can only be viewed in IMS, which is not accessible to guest users
        $this->assertDatabaseHas('appointments', [
            'name' => 'Test Name', 
            'phone_number' => '0123456', 
            'email' => 'test.name@gmail.com', 
            'artwork_id' => $artwork->id, 
        ]);

        //clean up
        DB::table('appointments')->where('name', '=', 'Test Name')->where('datetime', '=', '2100-01-01-14:00')->where('artwork_id', '=', $artwork->id)->delete();
    }

    /**
     * @group web-portal
     * @group appointments
     * @return void
     */
    public function test_ShouldNot_EditAppointment_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $artwork = Artwork::all()->first();
            $browser->visit('/ims/appointments/edit/' . $artwork->id)
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @group appointments
     * @return void
     */
    public function test_Should_SeeAppointment_When_UserIsStaff()
    {
        $this->loginAsStaff();

        $this->browse(function ($browser) {

            //find first artwork
            $artwork = Artwork::visible()->first();

            //ensure that the appointment does not already exist
            DB::table('appointments')->where('datetime', '=', '2100-01-01-14:00')->delete();
            $appointment = factory(Appointment::class)->create(['name' => 'Test Name', 'phone_number' => '0123456', 'email' => 'test.name@gmail.com', 'datetime' => '2100-01-01-14:00', 'artwork_id' => $artwork->id]);
            $browser->visit('/ims/appointments/1/1/2100')
                    ->assertSee('Test Name')
                    ->assertSee('0123456')
                    ->assertSee('test.name@gmail.com')
                    ->assertSee($artwork->title);
            //clean up
            DB::table('appointments')->where('name', '=', 'Test Name')->where('datetime', '=', '2100-01-01-14:00')->where('artwork_id', '=', $artwork->id)->delete();
        });

        $this->logout();
    }

    /**
     * @group ims
     * @group appointments
     * @return void
     */
    public function test_Should_CancelAppointment_When_UserIsStaff()
    {
        $this->loginAsStaff();

        $this->browse(function ($browser) {

            //find first artwork
            $artwork = Artwork::visible()->first();

            //ensure that the appointment does not already exist
            DB::table('appointments')->where('datetime', '=', '2100-01-01-14:00')->delete();
            $appointment = factory(Appointment::class)->create(['name' => 'Test Name', 'phone_number' => '0123456', 'email' => 'test.name@gmail.com', 'datetime' => '2100-01-01-14:00', 'artwork_id' => $artwork->id]);

            $browser->visit('/ims/appointments/1/1/2100')
                    ->clickLink('Delete')
                    ->assertPathIs('/ims/appointments/delete/' . $appointment->id)
                    ->clickLink('Confirm Delete')
                    ->visit('/ims/appointments/1/1/2100')
                    ->assertDontSee('Test Name');
        });

        $this->logout();
    }

    /**
     * @group ims
     * @group appointments
     * @group current
     * @return void
     */
    public function test_Should_MarkAppointmentAsLeadingToSale_When_StaffLogsAppointmentAsLeadingToSale()
    {
        //find first artwork
        $artwork = Artwork::visible()->first();

        //ensure that the appointment does not already exist
        DB::table('appointments')->where('datetime', '=', '2100-01-01-14:00')->delete();
        $appointment = factory(Appointment::class)->create(['name' => 'Test Name', 'phone_number' => '0123456', 'email' => 'test.name@gmail.com', 'datetime' => '2100-01-01-14:00', 'artwork_id' => $artwork->id]);

        $this->loginAsStaff();

        $this->browse(function ($browser) use ($artwork, $appointment) {
            $browser->visit('/ims/appointments/1/1/2100')
                    ->clickLink('Mark As Sale')
                    ->assertPathIs('/ims/appointments')
                    ->assertSee('The appointment was marked as leading to a sale')
                    ->visit('/ims/appointments/1/1/2100')
                    ->assertDontSee('Mark As Sale');
        });

        $this->logout();

        DB::table('appointments')->where('datetime', '=', '2100-01-01-14:00')->delete();
    }


    private function loginAsStaff() 
    {
        $this->browse(function ($browser) {

            $user = User::Admins()->first();

            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', $user->email)
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS");
        }); 
    }

    private function loginAsManager() 
    {
        $this->browse(function ($browser) {

            $user = User::Managers()->first();

            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', $user->email)
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS");
        }); 
    }


    private function logout() 
    {
        $this->browse(function ($browser) {
            $browser->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }


}
