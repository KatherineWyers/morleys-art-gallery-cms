<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExhibitionsTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasCurrentExhibition()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Current Exhibition');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasFutureExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Future Exhibitions');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testHasPastExhibitions()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Past Exhibitions')
                    ->assertSee('2015')
                    ->assertSee('2016')
                    ->assertSee('2017');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testLinkToPastExhibitionIsValid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->clickLink('2015')
                    ->assertSee('2015 Exhibitions');
        });
    }
}
