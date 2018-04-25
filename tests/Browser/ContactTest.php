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
            $browser->resize(1366, 768)
                    ->visit('/contact')
                ->assertSee('+44 1234 5678')
                ->assertSee('37 Marlborough Court')
                ->assertSee('Stratford-upon-Avon')
                ->assertSee('EI1 6NJ')
                ->assertSee('Opening Times');
        });
    }
}
