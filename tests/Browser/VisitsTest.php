<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;
use App\User;

use Illuminate\Support\Facades\DB;

class VisitsTest extends DuskTestCase
{

    /**
     * @group visits
     *
     * @return void
     */
    public function test_Should_LogVisits_When_GuestVisitsPage()
    {
        $artwork = Artwork::visible()->first();
        $visitor_id = $this->getNextVisitorId();

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee('We use cookies to ensure that we give you the best experience on our website')
                    ->visit('/artworks/'. $artwork->id)
                    ->assertDontSee('We use cookies to ensure that we give you the best experience on our website')
                    ->assertPathIs('/artworks/' . $artwork->id);
        });

        $visit_count = DB::table('visits')->where('visitor_id', '=', $visitor_id)->where('url', '=', 'http://localhost')->count();
        $this->assertTrue($visit_count == 1);

        $visit_count = DB::table('visits')->where('visitor_id', '=', $visitor_id)->where('url', '=', 'http://localhost/artworks/' . $artwork->id)->count();
        $this->assertTrue($visit_count == 1);

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertDontSee('We use cookies to ensure that we give you the best experience on our website')
                    ->visit('/artworks/'. $artwork->id)
                    ->assertDontSee('We use cookies to ensure that we give you the best experience on our website')
                    ->assertPathIs('/artworks/' . $artwork->id);
        });

        $visit_count = DB::table('visits')->where('visitor_id', '=', $visitor_id)->where('url', '=', 'http://localhost')->count();
        $this->assertTrue($visit_count == 2);

        $visit_count = DB::table('visits')->where('visitor_id', '=', $visitor_id)->where('url', '=', 'http://localhost/artworks/' . $artwork->id)->count();
        $this->assertTrue($visit_count == 2);
    }

    /**
     * @group visits
     * @return void
     */
    public function test_Should_DisplayUnauthorized_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/ims/visits')
                    ->assertSee('Unauthorized'); 
        });
    }


   /**
     * @group visits
     *
     * @return void
     */
    public function test_Should_IncreaseTotalVisitsForUrl_When_GuestVisitsPage()
    {
        $artwork = Artwork::visible()->first();
        $visit_count_homepage_before_test = DB::table('visits')->where('url', '=', 'http://localhost')->count();
        $visit_count_artwork_before_test = DB::table('visits')->where('url', '=', 'http://localhost/artworks/' . $artwork->id)->count();
        $this->loginAsStaff();
        $this->browse(function (Browser $browser) use ($artwork, $visit_count_homepage_before_test, $visit_count_artwork_before_test) {
            $browser->resize(1366, 768)
                    ->visit('/ims/visits')
                    ->assertSee('URL: http://localhost => Visits: ' . $visit_count_homepage_before_test)
                    ->assertSee('URL: http://localhost/artworks/' . $artwork->id . ' => Visits: ' . $visit_count_artwork_before_test);
        });
        $this->logout();

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->visit('/artworks/'. $artwork->id)
                    ->visit('/')
                    ->visit('/artworks/'. $artwork->id)
                    ->visit('/artworks')
                    ->visit('/artworks/'. $artwork->id);
        });

        $visit_count_homepage_after_test = DB::table('visits')->where('url', '=', 'http://localhost')->count();
        $visit_count_artwork_after_test = DB::table('visits')->where('url', '=', 'http://localhost/artworks/' . $artwork->id)->count();
        $this->assertTrue($visit_count_homepage_after_test == $visit_count_homepage_before_test + 2);
        $this->assertTrue($visit_count_artwork_after_test == $visit_count_artwork_before_test + 3);

        $this->loginAsStaff();
        $this->browse(function (Browser $browser) use ($artwork, $visit_count_homepage_after_test, $visit_count_artwork_after_test) {
            $browser->resize(1366, 768)
                    ->visit('/ims/visits')
                    ->assertSee('URL: http://localhost => Visits: ' . $visit_count_homepage_after_test)
                    ->assertSee('URL: http://localhost/artworks/' . $artwork->id . ' => Visits: ' . $visit_count_artwork_after_test);
        });
        $this->logout();
    }

    private function getNextVisitorId()
    {
        return DB::table('visits')->max('visitor_id') + 1;
    }

    private function loginAsStaff() 
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::Admins()->first());
        }); 
    }

    private function logout() 
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
