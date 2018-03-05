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
    public function testHasLinkToArtist()
    {
        $this->browse(function (Browser $browser) {
            $artist = Artist::first();

            $browser->visit('/artists')
                    ->assertSee($artist->name)
                    ->clickLink($artist->name)
                    ->assertPathIs('/artists/' . $artist->id)
                    ->assertSee($artist->name);
        });
    }
}
