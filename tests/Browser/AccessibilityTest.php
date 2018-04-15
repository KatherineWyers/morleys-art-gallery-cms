<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Artwork;
use App\Artist;
use App\VisitHandler;

class AccessibilityTest extends DuskTestCase
{
    /**
     * @group web-portal
     * @group accessibility
     *
     * @return void
     */
    public function test_Should_DisplayRegularFont_When_FirstVisit()
    {
        $artwork = Artwork::visible()->first();
        $artist = Artist::all()->first();
        $this->browse(function (Browser $browser) use ($artwork, $artist) {
            $browser->visit('/')
                    ->assertSee('Standard Mode')
                    ->visit('/artworks')
                    ->assertSee('Standard Mode')
                    ->visit('/artists')
                    ->assertSee('Standard Mode')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee('Standard Mode')
                    ->visit('/artists/' . $artist->id)
                    ->assertSee('Standard Mode');
        });
    }


    /**
     * @group web-portal
     * @group accessibility
     *
     * @return void
     */
    public function test_Should_KeepAccessibleModeForMultiplePages_When_VisitorSetsAccessibleMode()
    {
        $artwork = Artwork::visible()->first();
        $artist = Artist::all()->first();
        $this->browse(function (Browser $browser) use ($artwork, $artist) {
            $browser->visit('/')
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->visit('/artworks')
                    ->assertSee('Accessible Mode')
                    ->visit('/artists')
                    ->assertSee('Accessible Mode')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee('Accessible Mode')
                    ->visit('/artists/' . $artist->id)
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode');
        });
    }


    /**
     * @group web-portal
     * @group accessibility
     *
     * @return void
     */
    public function test_Should_BeSwitchable_When_VisitorVisitsAnyPage()
    {
        $artwork = Artwork::visible()->first();
        $artist = Artist::all()->first();
        $this->browse(function (Browser $browser) use ($artwork, $artist) {
            $browser->visit('/')
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode')
                    ->visit('/artworks')
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode')
                    ->visit('/artists')
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode')
                    ->visit('/artists/' . $artist->id)
                    ->assertSee('Standard Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Accessible Mode')
                    ->click('input[name="accessibility"]')
                    ->assertSee('Standard Mode');
        });
    }    

}
