<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artist;

class ArtistsTest extends DuskTestCase
{
    /**
     * @group web-portal
     * @group artists
     *
     * @return void
     */
    public function testHasLinkToArtist()
    {
        $this->browse(function (Browser $browser) {
            $artist = Artist::first();
            $browser->visit('/artists')
                    ->assertSee($artist->name)
                    ->clickLink($artist->name)
                    ->assertPathIs('/artists/' . $artist->id)
                    ->assertSee($artist->name);
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testGuestCannotOpenCreateNewArtist()
    {
        $this->browse(function ($browser) {
            $browser->visit('/artists/create')
                    ->assertDontSee('Create'); 
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testGuestCannotSeeLinkToCreateNewArtist()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Artists')
                    ->assertDontSee("+ Add New Artist");
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testGuestCannotSeeLinkToEditArtist()
    {
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->visit('/artists/' . $artist->id)
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testStaffCanSeeLinkToCreateNewArtist()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->clickLink('Artists')
                    ->assertSee("+ Add New Artist");
        });
        $this->logout();
    }


    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testStaffCreateNewArtistAndViewInTheIndex()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);
            $next_id = $artist->id + 1;

            // create a new artist
            $browser->visit('/artists/create')
                    ->attach('profile_img', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('featured_artwork_img_lg', 'C:/Databases/morleys/public/img/placeholders/1240x700.png')
                    ->attach('featured_artwork_img_sm', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->type('name', 'Random Name')
                    ->type('desc_1', 'Lorum ipsum Text')
                    ->click('input[type="submit"]')
                    ->assertPathIs('/artists/' . $next_id);
        });

        $this->logout();
    }


    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testStaffCreateNewArtistPhotoIsTheWrongSize()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);
            $next_id = $artist->id + 1;

            // create a new artist
            $browser->visit('/artists/create')
                    ->attach('profile_img', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('featured_artwork_img_lg', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->attach('featured_artwork_img_sm', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->type('name', 'Random Name')
                    ->type('desc_1', 'Lorum ipsum Text')
                    ->click('input[type="submit"]')
                    ->assertSee('The featured artwork img lg has invalid image dimensions');
        });

        $this->logout();
    }










    // /**
    //  * @group cms
    //  * @group artists
    //  * @return void
    //  */
    // public function testStaffEditArtistAndViewChangesInTheIndex()
    // {
    //     // KW:: to do
    // }




    

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function testStaffCanSeeLinkToEditArtist()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->visit('/artists/' . $artist->id)
                    ->assertSee("Edit");
        });
        $this->logout();
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
