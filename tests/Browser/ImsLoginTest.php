<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;

class ImsLoginTest extends DuskTestCase
{


    /**
     * @group ims
     * @return void
     */
    public function testGuestCannotAccessIms() {
        $this->browse(function ($browser) {
            $browser->visit('/ims')
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @return void
     */
    public function testGuestCannotAccessImsPos() {
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->visit('/ims/pos/' . $artwork->id)
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @return void
     */
    public function testStaffCanSeeImsAndLogout() {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertPathIs('/')
                    ->assertSee('IMS')
                    ->clickLink('IMS')
                    ->assertPathIs('/ims')
                    ->assertSee('Information Management System')
                    ->visit('/logout')
                    ->logout()
                    ->visit('/ims')
                    ->assertSee('Unauthorized');
        }); 
    }

    /**
     * @group ims
     * @return void
     */
    public function testStaffLoginsInCanSeeSalesBtnInArtworksShowAndLogout() {
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->visit('/')
                    ->clickLink('Login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee('Process Sale')
                    ->logout();
        }); 
    }

    /**
     * @group ims
     * @return void
     */
    public function testStaffCanReachImsPos() {
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->visit('/')
                    ->clickLink('Login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee('Process Sale')
                    ->clickLink('Process Sale')
                    ->assertPathIs('/ims/pos/' . $artwork->id)
                    ->assertSee('Process Sale')
                    ->logout();
        }); 
    }

    /**
     * @group ims
     * @group current
     * @return void
     */
    public function testStaffCanProcessSaleInImsPos() {
        //
    }
}