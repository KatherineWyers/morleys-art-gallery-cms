<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\WeeklyTimeslot;

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
     * @group weekly-timeslots
     * @group current
     * @return void
     */
    public function test_Should_UpdateWeeklyTimeslots_When_StaffSelectsWeeklyTimeslots()
    {
        $original_weekly_timeslots = WeeklyTimeslot::checked()->get();

        //set the initial state
        foreach($original_weekly_timeslots as $weekly_timeslot)
        {
            $weekly_timeslot->checked = FALSE;
            $weekly_timeslot->save();
        }

        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/ims/weekly_timeslots/edit')
                    ->check("input[name='weekly_timeslots[]']")
                    ->click('input[type="submit"]')
                    ->assertPathIs('/ims/weekly_timeslots')
                    ->assertSee('Weekly timeslots updated successfully');
        });
        $this->logout();

        $this->assertDatabaseHas('weekly_timeslots', ['id' => 1, 'checked' => TRUE]);

        //reset the environment
        foreach($original_weekly_timeslots as $weekly_timeslot)
        {
            $weekly_timeslot->checked = TRUE;
            $weekly_timeslot->save();
        }
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
