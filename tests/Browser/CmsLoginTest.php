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
    public function testGuestCannotOpenCreateNewArtist()
    {
        $this->browse(function ($browser) {
            $browser->visit('/artists/create')
                    ->assertNotSee('Create'); 
        });
    }

    /**
     * @group cms
     * @return void
     */
    public function testStaffCanCreateNewArtist()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertSee('Login')
                    ->value('#email', 'staff1@example.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertPathIs('/')
                    ->assertSee("Appointments"); 
        });
    }
}
