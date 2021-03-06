<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Exhibition;
use App\NewsArticle;
use App\Artist;
use App\Artwork;

class CmsLoginTest extends DuskTestCase
{

    /**
     * @group cms
     * @return void
     */
    public function test_Should_LoginAsStaff_When_UserLoginCredentialsAreValid() {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS")
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }

    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_GrantAccessForCMSAndIMS_When_LoggedInAsCustomer() {
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->visit('/artworks')
                    ->assertPathIs('/artworks')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('Add New Artwork')
                    ->visit('/ims')
                    ->assertSee('Unauthorized')
                    ->visit('/artworks/create')
                    ->assertSee('Unauthorized');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShould_GrantAccessForCMSAndIMS_When_LoggedInAsStaff() {
        $user = $this->loginAsStaff();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee($user->name)
                    ->assertSee('IMS')
                    ->visit('/artworks')
                    ->assertPathIs('/artworks')
                    ->assertSee($user->name)
                    ->assertSee('IMS')
                    ->assertSee('Add New Artwork')
                    ->visit('/ims')
                    ->assertDontSee('Unauthorized')
                    ->visit('/artworks/create')
                    ->assertDontSee('Unauthorized');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShould_GrantAccessForCMSAndIMS_When_LoggedInAsManager() {
        $user = $this->loginAsManager();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee($user->name)
                    ->assertSee('IMS')
                    ->visit('/artworks')
                    ->assertPathIs('/artworks')
                    ->assertSee($user->name)
                    ->assertSee('IMS')
                    ->assertSee('Add New Artwork')
                    ->visit('/ims')
                    ->assertDontSee('Unauthorized')
                    ->visit('/artworks/create')
                    ->assertDontSee('Unauthorized');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInArtworksShow_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $artwork = Artwork::visible()->first();
        $this->browse(function ($browser) use ($user, $artwork) {
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->assertPathIs('/artworks/' . $artwork->id)
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Edit');
        }); 
        $this->logout();
    }


    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInArtists_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->visit('/artists')
                    ->assertPathIs('/artists')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Add New Artist');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInArtistsShow_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $artist = Artist::all()->first();
        $this->browse(function ($browser) use ($user, $artist) {
            $browser->resize(1366, 768)
                    ->visit('/artists/' . $artist->id)
                    ->assertPathIs('/artists/' . $artist->id)
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Edit');
        }); 
        $this->logout();
    }


    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInExhibitions_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions')
                    ->assertPathIs('/exhibitions')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Add New Exhibition');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInExhibitionsShow_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $exhibition = Exhibition::all()->first();
        $this->browse(function ($browser) use ($user, $exhibition) {
            $browser->resize(1366, 768)
                    ->visit('/exhibitions/' . $exhibition->id)
                    ->assertPathIs('/exhibitions/' . $exhibition->id)
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Edit');
        }); 
        $this->logout();
    }


    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInNewsArticles_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($user) {
            $browser->resize(1366, 768)
                    ->visit('/news_articles')
                    ->assertPathIs('/news_articles')
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Add New Article');
        }); 
        $this->logout();
    }

    /**
     * @group cms
     * @return void
     */
    public function testShouldNot_ShowStaffLinksInNewsArticlesShow_When_CustomerLogsIn() {
        $user = $this->loginAsCustomer();
        $news_article = NewsArticle::all()->first();
        $this->browse(function ($browser) use ($user, $news_article) {
            $browser->resize(1366, 768)
                    ->visit('/news_articles/' . $news_article->id)
                    ->assertPathIs('/news_articles/' . $news_article->id)
                    ->assertSee($user->name)
                    ->assertDontSee('IMS')
                    ->assertDontSee('(Customer)')
                    ->assertDontSee('Edit');
        }); 
        $this->logout();
    }


    private function loginAsCustomer() 
    {
        $user = User::Customers()->first();
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user);
        }); 
        return $user;
    }

    private function loginAsManager() 
    {
        $user = User::Managers()->first();
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user);
        }); 
        return $user; 
    }

    private function loginAsStaff() 
    {
        $user = User::Admins()->first();
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user);
        }); 
        return $user; 
    }

    private function logout() 
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout();
        }); 
    }

}
