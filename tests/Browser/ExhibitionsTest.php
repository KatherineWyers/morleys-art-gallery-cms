<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Exhibition;

class ExhibitionsTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function test_Should_DisplayCurrentExhibitionText_When_UserIsGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
                    ->assertSee('Current Exhibition');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function test_Should_DisplayFutureExhibitionsText_When_UserIsGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
                    ->assertSee('Future Exhibitions');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function test_Should_DisplayExhibitionsByYear_When_UserIsGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
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
    public function test_Should_DisplayUnauthorizedInCreateForm_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions/create')
                    ->assertSee('Unauthorized'); 
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_NotDisplayCreateButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
                    ->assertDontSee("+ Add New Exhibition");
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_NotDisplayEditButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $exhibition = Exhibition::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/exhibitions/' . $exhibition->id)
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_DisplayCreateButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
                    ->assertSee("+ Add New Exhibition");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_CreateExhibition_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {


            $title = $this->generateRandomString(10);
            $desc_1 = $this->generateRandomString(10);

            $exhibition = factory(\App\Exhibition::class)->create([]);
            $next_id = $exhibition->id + 1;

            $browser->resize(1366, 768)
                    ->visit('/exhibitions/create')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/1200x300.png')
                    ->attach('img_2', 'C:/Databases/morleys/public/img/placeholders/600x300.png')
                    ->value('input[name=title]',$title)
                    ->type('start_date', '2018-06-09')
                    ->type('end_date', '2018-06-22')
                    ->type('desc_1', $desc_1)
                    ->click('input[type="submit"]')
                    ->assertPathIs('/exhibitions/' . $next_id)
                    ->assertSee($title)
                    ->assertSee('09-Jun-2018')
                    ->assertSee('22-Jun-2018')
                    ->assertSee($desc_1);

        });
        $this->logout();
    }


    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_DisplayEditButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $exhibition = Exhibition::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/exhibitions/' . $exhibition->id)
                    ->assertSee("Edit");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group exhibitions
     * @return void
     */
    public function test_Should_EditExhibition_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $title = $this->generateRandomString(10);
            $desc_1 = $this->generateRandomString(10);

            $exhibition = factory(\App\Exhibition::class)->create([]);

            $browser->resize(1366, 768)
                    ->visit('/exhibitions/' . $exhibition->id . '/edit')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/1200x300.png')
                    ->attach('img_2', 'C:/Databases/morleys/public/img/placeholders/600x300.png')
                    ->value('input[name=title]',$title)
                    ->type('start_date', '2018-06-10')
                    ->type('end_date', '2018-06-23')
                    ->type('desc_1', $desc_1)
                    ->click('input[type="submit"]')
                    ->assertPathIs('/exhibitions/' . $exhibition->id)
                    ->assertSee($title)
                    ->assertSee('10-Jun-2018')
                    ->assertSee('23-Jun-2018')
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
