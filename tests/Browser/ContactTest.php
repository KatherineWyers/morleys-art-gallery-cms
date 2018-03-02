<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactTest extends DuskTestCase
{
    /**
     * @group web-portal
     *
     * @return void
     */
    public function testHasCorrectContactDetails()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/contact')
                ->assertSee('+44 1234 5678')
                ->assertSee('37 Marlborough Court')
                ->assertSee('Straford-upon-Avon')
                ->assertSee('EI1 6NJ');
        });
    }
}
