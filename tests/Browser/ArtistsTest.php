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
    public function test_Should_DisplayLink_When_UserIsGuest()
    {
        $this->browse(function (Browser $browser) {
            $artist = Artist::first();
            $browser->resize(1366, 768)
                    ->visit('/artists')
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
    public function test_Should_DisplayUnauthorized_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/artists/create')
                    ->assertSee('Unauthorized'); 
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_NotDisplayCreateButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->clickLink('Artists')
                    ->assertDontSee("+ Add New Artist");
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_NotDisplayEditButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/artists/' . $artist->id)
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_DisplayCreateButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
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
    public function test_Should_CreateArtist_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);
            $next_id = $artist->id + 1;

            // create a new artist
            $browser->resize(1366, 768)
                    ->visit('/artists/create')
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
    public function test_Should_DisplayError_When_ImageSizeIsWrong()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);
            $next_id = $artist->id + 1;

            // create a new artist
            $browser->resize(1366, 768)
                    ->visit('/artists/create')
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



    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_EditArtist_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);

            // create a new artist
            $browser->resize(1366, 768)
                    ->visit('/artists/' . $artist->id . '/edit')
                    ->type('name', 'Test Name')
                    ->type('desc_1', 'Test Description of the Artist')
                    ->click('input[type="submit"]')
                    ->visit('/artists/' . $artist->id)
                    ->assertSee('Test Name')
                    ->assertSee('Test Description of the Artist');
        });

        $this->logout();
    }

    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_DisplayError_When_EditImageSizeIsWrong()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            //create a new Artist to determine the current autoincrement
            $artist = factory(\App\Artist::class)->create([]);

            // edit the new artist
            $browser->resize(1366, 768)
                    ->visit('/artists/' . $artist->id . '/edit')
                    ->attach('profile_img', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->attach('featured_artwork_img_lg', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('featured_artwork_img_sm', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->type('name', 'Random Name')
                    ->type('desc_1', 'Lorum ipsum Text')
                    ->click('input[type="submit"]')
                    ->assertSee('The profile img has invalid image dimensions')
                    ->assertSee('The featured artwork img lg has invalid image dimensions')
                    ->assertSee('The featured artwork img sm has invalid image dimensions');
        });

        $this->logout();
    }


    /**
     * @group cms
     * @group artists
     * @return void
     */
    public function test_Should_DisplayEditButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/artists/' . $artist->id)
                    ->assertSee("Edit");
        });
        $this->logout();
    }

    private function loginAsStaff() {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
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
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
