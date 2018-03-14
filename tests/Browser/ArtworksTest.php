<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;

class ArtworkTest extends DuskTestCase
{


    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testGuestCannotOpenCreateNewArtwork()
    {
        $this->browse(function ($browser) {
            $browser->visit('/artworks/create')
                    ->assertDontSee('Create'); 
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testGuestCannotSeeLinkToCreateNewArtwork()
    {
        $this->browse(function ($browser) {
            $browser->visit('/artworks')
                    ->assertDontSee("+ Add New Artwork");
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testGuestCannotSeeLinkToEditArtwork()
    {
        $this->browse(function ($browser) {
            $browser->visit('/artworks/1')
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testStaffCanSeeLinkToCreateNewArtwork()
    {
    	$this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/artworks')
                    ->assertSee("+ Add New Artwork");
        });
    	$this->logout();
    }


    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testStaffCreateNewArtworkAndViewInTheIndex()
    {
        // KW:: to do
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testStaffCanSeeLinkToEditArtwork()
    {
    	$this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/artworks/1')
                    ->assertSee("Edit");
        });
    	$this->logout();
    }


    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function testStaffEditArtworkAndViewChangesInTheIndex()
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
