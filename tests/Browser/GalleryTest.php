<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GalleryTest extends DuskTestCase
{
    /**
     * @group web-portal
     *
     * @return void
     */
    public function testCorrectBodyText()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/gallery')
                    ->assertSee('Gallery');
        });
    }
}
