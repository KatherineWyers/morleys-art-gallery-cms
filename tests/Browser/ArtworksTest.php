<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArtworkTest extends DuskTestCase
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
            $browser->visit('/artworks/1')
                    ->assertSee('John Doe')
                    ->assertSee('Untitled')
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
            $browser->visit('/artworks/1')
                    ->assertSee('Next')
                    ->clickLink('Next')
                    ->assertPathIs('/artworks/2')
                    ->assertSee('John Doe')
                    ->assertSee('Untitled');
        });
    }
}
