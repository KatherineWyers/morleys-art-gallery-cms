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
    public function testHasExhibitionsByYear()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/exhibitions')
                    ->assertSee('Exhibitions By Year')
                    ->assertSee('2015')
                    ->assertSee('2016')
                    ->assertSee('2017')
                    ->assertSee('2018');
        });
    }


    /**
     * @group web-portal
     * @group exhibitions
     * @return void
     */
    public function testLinkToPastExhibitionIsValid()
    {
        // todo
    }
}
