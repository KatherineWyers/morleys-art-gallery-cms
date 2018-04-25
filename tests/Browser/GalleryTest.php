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
            $browser->resize(1366, 768)
                    ->visit('/gallery')
                    ->assertSee('Gallery');
        });
    }
}
