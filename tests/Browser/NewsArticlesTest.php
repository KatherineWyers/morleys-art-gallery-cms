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
            $browser->visit('/news_articles')
                    ->assertSee('News');
        });
    }


    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_DisplayUnauthorizedInCreateForm_When_UserIsGuest()
    {
        $this->browse(function ($browser) {
            $browser->visit('/news_articles/create')
                    ->assertSee('Unauthorized'); 
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
            $browser->visit('/news_articles')
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
            $browser->visit('/news_articles/' . $news_article->id)
                    ->assertDontSee("Edit");
        });
    }

    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_DisplayCreateButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->visit('/news_articles')
                    ->assertSee("+ Add New News Article");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_CreateNewsArticle_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {


            $title = $this->generateRandomString(10);
            $content = $this->generateRandomString(10);

            $news_article = factory(\App\NewsArticle::class)->create([]);
            $next_id = $news_article->id + 1;

            $browser->visit('/news_article/create')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->value('input[name=title]',$title)
                    ->assertSee($content);

        });
        $this->logout();
    }


    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_DisplayEditButton_When_UserIsStaff()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $news_article = NewsArticle::all()->first();
            $browser->visit('/news_articles/' . $news_article->id)
                    ->assertSee("Edit");
        });
        $this->logout();
    }

    /**
     * @group cms
     * @group news_articles
     * @return void
     */
    public function test_Should_EditNewsArticle_When_FormDataIsValid()
    {
        $this->loginAsStaff();
        $this->browse(function ($browser) {
            $title = $this->generateRandomString(10);
            $content = $this->generateRandomString(10);

            $news_article = factory(\App\NewsArticle::class)->create([]);

            $browser->visit('/news_articles/' . $news_article->id . '/edit')
                    ->attach('img_1', 'C:/Databases/morleys/public/img/placeholders/300x300.png')
                    ->value('input[name=title]',$title)
                    ->assertSee($content);
        });

        $this->logout();
    }



    private function loginAsStaff() {
        $this->browse(function ($browser) {
            $browser->visit('/')
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
            $browser->visit('/logout')
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
