<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;
use App\Artist;


class ArtworkTest extends DuskTestCase
{


    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_DisplayUnauthorized_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/artworks/create')
                    ->assertSee('Unauthorized'); 
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_NotDisplayCreateButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/artworks')
                    ->assertDontSee("+ Add New Artwork");
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_NotDisplayEditButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_DisplayCreateButton_When_UserIsStaff()
    {
    	$this->loginAsStaff();

        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/artworks')
                    ->assertSee("+ Add New Artwork");
        });
    	$this->logout();
    }


    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_DisplayNotification_When_NoCategoriesSelected()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artist = Artist::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/create')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_2', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_3', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_sq', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->value('input[name=title]','Beautiful Flowers')
                    ->select('artist_id', $artist->id)
                    ->type('year_created', 2005)
                    ->type('medium', 'Oil on canvas')
                    ->type('width_cm', 7.0)
                    ->type('height_cm', 8.1)
                    ->type('width_in', 9.2)
                    ->type('height_in', 10.3)
                    ->type('price', 6000)
                    ->type('desc_1', 'Description Text')
                    ->click('input[type="submit"]')
                    ->assertPathIs('/artworks/create')
                    ->assertSee('The categories field is required');
        });
        $this->logout();
    }





    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_CreateArtwork_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artwork = factory(\App\Artwork::class)->create([]);
            $next_id = $artwork->id + 1;

            $artist = Artist::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/create')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_2', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_3', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_sq', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->value('input[name=title]','Beautiful Flowers')
                    ->check("input[name='categories[]']")
                    ->select('artist_id', $artist->id)
                    ->type('year_created', 2005)
                    ->type('medium', 'Oil on canvas')
                    ->type('width_cm', 7.0)
                    ->type('height_cm', 8.1)
                    ->type('width_in', 9.2)
                    ->type('height_in', 10.3)
                    ->type('price', 6000)
                    ->type('desc_1', 'Description Text')
                    ->click('input[type="submit"]')
                    ->assertPathIs('/artworks/' . $next_id)
                    ->assertSee('Beautiful Flowers')
                    ->assertSee($artist->name)
                    ->assertSee('2005')
                    ->assertSee('Oil on canvas')
                    ->assertSee('7')
                    ->assertSee('8.1')
                    ->assertSee('9.2')
                    ->assertSee('10.3')
                    ->assertSee('6000')
                    ->assertSee('Description Text');

        });
        $this->logout();
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_DisplayEditButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee("Edit");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_DisplayProcessSaleButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee("Process Sale");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group artworks
     * @return void
     */
    public function test_Should_EditArtwork_When_FormDataIsValid()
    {
    	$this->loginAsStaff();
        $this->browse(function ($browser) {

            $title = $this->generateRandomString(10);
            $year_created = rand(2000,2010);
            $price = rand(500,8000);
            $desc_1 = $this->generateRandomString(10);

            $artist = Artist::all()->first();
            $artwork = Artwork::where('visible', TRUE)->first();
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id . '/edit')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_2', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_3', 'C:/Databases/morleys/public/img/placeholders/400x600.png')
                    ->attach('img_sq', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->value('input[name=title]',$title)
                    ->check("input[name='categories[]']")
                    ->select('artist_id', $artist->id)
                    ->type('year_created', $year_created)
                    ->type('medium', 'Oil on canvas')
                    ->type('width_cm', 7.0)
                    ->type('height_cm', 8.1)
                    ->type('width_in', 9.2)
                    ->type('height_in', 10.3)
                    ->type('price', $price)
                    ->type('desc_1', $desc_1)
                    ->click('input[type="submit"]')
                    ->assertPathIs('/artworks/' . $artwork->id)
                    ->assertSee($title)
                    ->assertSee($artist->name)
                    ->assertSee($year_created)
                    ->assertSee('Oil on canvas')
                    ->assertSee('7')
                    ->assertSee('8.1')
                    ->assertSee('9.2')
                    ->assertSee('10.3')
                    ->assertSee($price)
                    ->assertSee($desc_1);
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


    private function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
