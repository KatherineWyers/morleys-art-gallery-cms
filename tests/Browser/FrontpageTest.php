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
            $browser->visit('/')
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
            $browser->visit('/')
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
            $browser->visit('/')
                    ->assertSee('News');
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
            $browser->visit('/')
                    ->assertSee('+44 1234 5678')
                    ->assertSee('37 Marlborough Court')
                    ->assertSee('Straford-upon-Avon')
                    ->assertSee('EI1 6NJ');
        });
    }

}

