<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArtworkPageTest extends DuskTestCase
{
    /**
     * @group web-portal
     * @group artworks
     * @return void
     */
    public function testArtworksIndexHasCorrectCategories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artworks')
                    ->assertSee('Modern British')
                    ->assertSee('Contemporary')
                    ->assertSee('Prints')
                    ->assertSee('Sculptures')
                    ->assertSee('Ceramics')
                    ->assertSee('Under £1000');
        });
    }


    /**
     * @group web-portal
     * @group artworks
     * @return void
     */
    public function testArtworkShowHasCorrectTextElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists/john-doe/untitled')
                    ->assertSee('John Doe')
                    ->assertSee('Untitled (2016)')
                    ->assertSee('Oil on canvas')
                    ->assertSee('177.8cm x 152cm')
                    ->assertSee('70in x 60in')
                    ->assertSee('£2540')
                    ->assertSee('Next');
        });
    }

    /**
     * @group web-portal
     * @group artworks
     * @return void
     */
    public function testArtworkShowHasCorrectNextLink()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists/john-doe/untitled')
                    ->assertSee('Next')
                    ->clickLink('Next')
                    ->assertPathIs('/artists/john-doe/untitled2')
                    ->assertSee('John Doe')
                    ->assertSee('Untitled (2016)');
        });
    }
}
