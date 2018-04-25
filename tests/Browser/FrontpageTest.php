<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FrontpageTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group frontpage
     * @return void
     */
    public function testHasFeaturedArtworks()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee('Featured Artworks');
        });
    }

    /**
     * @group web-portal
     * @group frontpage
     * @return void
     */
    public function testHasCurrentExhibition()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee('Current Exhibition');
        });
    }

    /**
     * @group web-portal
     * @group frontpage
     * @return void
     */
    public function testHasNews()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee('Latest News');
        });
    }

    /**
     * @group web-portal
     * @group frontpage
     * @return void
     */
    public function testHasContactDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee('+44 1234 5678')
                    ->assertSee('37 Marlborough Court')
                    ->assertSee('Stratford-upon-Avon')
                    ->assertSee('EI1 6NJ');
        });
    }

}

