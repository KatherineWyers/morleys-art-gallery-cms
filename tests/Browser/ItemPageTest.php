<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ItemPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testItemPageHasCorrectTextElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/items/demo-item')
                    ->assertSee('Demo Item')
                    ->assertSee('Description 1')
                    ->assertSee('Description 2')
                    ->assertSee('Sculpture')
                    ->assertSee('540');
        });
    }
}
