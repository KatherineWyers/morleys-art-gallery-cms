<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TimeslotsTest extends DuskTestCase
{
    /**
     * @group web-portal
     *
     * @return void
     */
    public function test_Should_DisplayRegularFont_When_FirstVisit()
    {
        $this->browse(function (Browser $browser) use ($artwork, $artist) {
            $browser->visit('/')
                    ->assertSee('Gallery');
        });
    }
}
