<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExhibitionsTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasCurrentExhibition()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Current Exhibition');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasFutureExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Future Exhibitions');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasExhibitionsByYear()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Exhibitions By Year')
                    ->assertSee('2015')
                    ->assertSee('2016')
                    ->assertSee('2017')
                    ->assertSee('2018');
        });
    }



    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testGuestCannotOpenCreateNewExhibition()
    {
        $this->browse(function ($browser) {
            $browser->visit('/exhibitions/create')
                    ->assertDontSee('Create'); 
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testGuestCannotSeeLinkToCreateNewExhibition()
    {
        $this->browse(function ($browser) {
            $browser->visit('/exhibitions')
                    ->assertDontSee("+ Add New Exhibition");
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testGuestCannotSeeLinkToEditExhibition()
    {
        $this->browse(function ($browser) {
            $browser->visit('/exhibitions/1')
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testStaffCanSeeLinkToCreateNewExhibition()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/exhibitions')
                    ->assertSee("+ Add New Exhibition");
        });
        $this->logout();
    }


    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testStaffCreateNewExhibitionAndViewInTheIndex()
    {
        // KW:: to do
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testStaffCanSeeLinkToEditExhibition()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/exhibitions/1')
                    ->assertSee("Edit");
        });
        $this->logout();
    }


    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function testStaffEditExhibitionAndViewChangesInTheIndex()
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
                    ->assertSee("Appointments");
        }); 
    }

    private function logout() {
        $this->browse(function ($browser) {
            $browser->visit('/logout')
                    ->logout()
                    ->assertDontSee("Appointments");
        }); 
    }

}
