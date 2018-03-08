<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CmsLoginTest extends DuskTestCase
{

    /**
     * @group cms
     * @return void
     */
    public function testStaffLogsInSeesAppointmentsLinkAndLogsOut() {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("Appointments")
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("Appointments");
        }); 
    }
}
