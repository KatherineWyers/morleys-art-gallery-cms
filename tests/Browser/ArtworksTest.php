<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;

class ArtworkTest extends DuskTestCase
{
    /**
     * @group web-portal
     * @group artworks
     * @return void
     */
    public function testArtworkShowHasCorrectTextElements()
    {
        $this->browse(function (Browser $browser) {
            $artwork = Artwork::first();

            $browser->visit('/artworks')
                    ->assertSee($artwork->title)
                    ->clickLink($artwork->title)
                    ->assertPathIs('/artworks/' . $artwork->id)
                    ->assertSee($artwork->title)
                    ->assertSee($artwork->medium)
                    ->assertSee($artwork->year_created)
                    ->assertSee($artwork->price)
                    ->assertSee($artwork->artist->name);
        });
    }

    /**
     * @group web-portal
     * @group artworks
     * @return void
     */
    public function testArtworkShowHasCorrectNextLink()
    {
        // todo
    }
}
