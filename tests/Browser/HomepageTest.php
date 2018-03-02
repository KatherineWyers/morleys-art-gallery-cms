<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomepageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testHomepageHasContactDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('+44 1234 5678')
                    ->assertSee('37 Marlborough Court')
                    ->assertSee('Straford-upon-Avon')
                    ->assertSee('EI1 6NJ');
        });
    }

    /**
     * @return void
     */
    public function testHomepageGallery()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('The Gallery')
                    ->assertPathIs('/');
        });
    }

    /**
     * @return void
     */
    public function testHomepageExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Exhibitions')
                    ->assertPathIs('/');
        });
    }

    /**
     * @return void
     */
    public function testHomepageArtworks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Artworks')
                    ->assertPathIs('/');
        });
    }

    /**
     * @return void
     */
    public function testHomepageAboutUs()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('About Us')
                    ->assertPathIs('/');
        });
    }

    /**
     * @return void
     */
    public function testHomepageNewsletter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Newsletter')
                    ->assertPathIs('/');
        });
    }
}
