<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
            $browser->visit('/artists')
                    ->assertSee('John Doe')
                    ->clickLink('John Doe')
                    ->assertPathIs('/artists/1');
        });
    }

    /**
     * @group web-portal
     * @group artists
     *
     * @return void
     */
    public function testArtistPageHasCorrectText()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/artists/1')
                    ->assertSee('John Doe')
                    ->assertSee('John Doe began his career as a metal-worker his family home in Arles, France.')
                    ->assertSee('In Focus')
                    ->assertSee('New York Times')
                    ->assertSee('John Doe is a fantastic sculptor.');
        });
    }
}
