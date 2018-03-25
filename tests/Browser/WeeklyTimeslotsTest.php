<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WeeklyTimeslotsTest extends DuskTestCase
{

    /**
     * @group ims
     * @group weekly_timeslots
     * @return void
     */
    public function testGuestCannotAccessWeeklyTimeslots() {
        $this->browse(function ($browser) {
            $browser->visit('/ims/weekly_timeslots')
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @group weekly_timeslots
     * @return void
     */
    public function testGuestCannotAccessWeeklyTimeslotsEditPage() {
        $this->browse(function ($browser) {
            $browser->visit('/ims/weekly_timeslots/edit')
                    ->assertSee('Unauthorized');
        }); 
    }



    /**
     * @group ims
     * @group weekly_timeslots
     * @return void
     */
    public function testStaffCanSeeWeeklyTimeslots()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/ims/weekly_timeslots')
                    ->assertSee("Weekly Timeslots");
        });
        $this->logout();
    }



    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testStaffCanSeeWeeklyTimeslotsEditPage()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/ims/weekly_timeslots/edit')
                    ->assertSee("Edit Weekly Timeslots");
        });
        $this->logout();
    }


    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testStaffEditWeeklyTimeslotUpdatesNumberOfWeeklyTimeslots()
    {
        // KW:: to do
    }

    private function loginAsStaff() {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS");
        }); 
    }

    private function logout() {
        $this->browse(function ($browser) {
            $browser->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
