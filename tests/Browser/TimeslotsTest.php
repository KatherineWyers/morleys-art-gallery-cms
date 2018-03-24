<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TimeslotsTest extends DuskTestCase
{

    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testGuestCannotAccessTimeslots() {
        $this->browse(function ($browser) {
            $browser->visit('/ims/timeslots')
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testGuestCannotAccessTimeslotsEditPage() {
        $this->browse(function ($browser) {
            $browser->visit('/ims/timeslots/edit')
                    ->assertSee('Unauthorized');
        }); 
    }



    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testStaffCanSeeTimeslots()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/ims/timeslots')
                    ->assertSee("Timeslots");
        });
        $this->logout();
    }



    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testStaffCanSeeTimeslotsEditPage()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/ims/timeslots/edit')
                    ->assertSee("Edit Timeslots");
        });
        $this->logout();
    }


    /**
     * @group ims
     * @group timeslots
     * @return void
     */
    public function testStaffEditTimeslotUpdatesNumberOfTimeslots()
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
