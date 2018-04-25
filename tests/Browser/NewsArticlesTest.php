<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\NewsArticle;

class NewsArticlesTest extends DuskTestCase
{

    /**
     * @group web-portal
     * @group news_articles
     * @return void
     */
    public function test_Should_DisplayNewsText_When_UserIsGuest()
    {
        $this->browse(function (Browser $browser) {
            $browser->resize(1366, 768)
                    ->visit('/news_articles')
                    ->assertSee('News');
        });
    }


    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_NotDisplayCreateButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/news_articles')
                    ->assertDontSee("+ Add New Exhibition");
        });
    }

    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_NotDisplayEditButton_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $news_article = NewsArticle::all()->first();
            $browser->resize(1366, 768)
                    ->visit('/news_articles/' . $news_article->id)
                    ->assertDontSee("Edit");
        });
    }



    private function loginAsStaff() {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', 'staff1@morleysgallery.com')
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS");
        }); 
    }

    private function logout() {
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }


    private function generateRandomString($length = 10) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
