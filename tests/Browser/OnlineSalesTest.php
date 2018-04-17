<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Artwork;
use App\User;

class OnlineSalesTest extends DuskTestCase
{
    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_PromptLogin_When_GuestTriesToMakeAnOnlinePurchase()
    {
        $artwork = Artwork::visible()->first();

        $this->browse(function ($browser) use ($artwork) {
            $browser->visit('/artworks/' . $artwork->id)
                    ->assertSee('Buy Online and Collect')
                    ->clickLink('Buy Online and Collect')
                    ->assertPathIs('/register')
                    ->assertSee('Register')
                    ->assertSee('Already have a profile? Login')
                    ->assertSee('You must be registered and logged in to shop online')
                    ->clickLink('Already have a profile? Login')
                    ->assertPathIs('/login');
        });
    }

    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_PurchaseArtwork_When_CustomerTriesToMakeAnOnlinePurchase()
    {
        $artwork = Artwork::visible()->first();

        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($artwork, $user) {
            $browser->visit('/artworks/' . $artwork->id)
                    ->assertSee($artwork->title)
                    ->assertSee('Buy Online and Collect')
                    ->clickLink('Buy Online and Collect')
                    ->assertPathIs('/pos/s/' . $artwork->id)
                    ->assertSee($user->name)
                    ->assertSee($artwork->title)
                    ->assertSee($artwork->price)
                    ->type('cc_name', 'Jane Doe')
                    ->type('cc_number', '4444333322221111')
                    ->type('cc_exp_mm', '01')
                    ->type('cc_exp_yyyy', '2020')
                    ->type('cc_cvv', '123')
                    ->click('input[type="submit"]')
                    ->assertSee('Item purchased successfully. It is now available for collection by ' . $user->name . ' at the gallery. Thank you')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertPathIs('/artworks')
                    ->assertSee('The requested artwork is no longer available');
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
            $browser->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
