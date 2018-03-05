<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WebPortalNavigationTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testFrontpageArtworks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Artworks')
                    ->assertPathIs('/');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testFrontpageExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Exhibitions')
                    ->assertPathIs('/');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testFrontpageNewsArticles()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('News')
                    ->assertPathIs('/');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testFrontpageGallery()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Gallery')
                    ->assertPathIs('/gallery')
                    ->assertSee('Gallery');
        });
    }


    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testFrontpageContact()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->clickLink('Contact')
                    ->assertPathIs('/contact')
                    ->assertSee('Contact');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageArtists()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('Artists')
                    ->assertPathIs('/artists')
                    ->assertSee('Artists');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageArtworks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('Artworks')
                    ->assertPathIs('/artworks')
                    ->assertSee('Artworks');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('Exhibitions')
                    ->assertPathIs('/exhibitions')
                    ->assertSee('Exhibitions');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageNewsArticles()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('News')
                    ->assertPathIs('/news_articles')
                    ->assertSee('News');
        });
    }

    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageGallery()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('Gallery')
                    ->assertPathIs('/gallery')
                    ->assertSee('Gallery');
        });
    }


    /**
     * @group web-portal
     * @group navigation
     * @return void
     */
    public function testStandardpageContact()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists')
                    ->clickLink('Contact')
                    ->assertPathIs('/contact')
                    ->assertSee('Contact');
        });
    }

}
