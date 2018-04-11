<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Artwork;
use App\User;
use App\Wishlist;

use Illuminate\Support\Facades\DB;

class WishlistsTest extends DuskTestCase
{

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_ShowLinkToAddToMyWishlist_When_GuestVisitsArtworkShowPage()
    {
        $artwork = Artwork::visible()->first();
        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->visit('/artworks/' . $artwork->id)
                    ->assertSee('Add to my Wishlist');
        });
    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_RedirectToLoginPage_When_GuestClicksAddToMyWishlist()
    {
        $artwork = Artwork::visible()->first();
        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->visit('/')
                    ->assertDontSee('My Wishlist')
                    ->visit('/artworks/' . $artwork->id)
                    ->clickLink('Add to my Wishlist')
                    ->assertPathIs('/login');
        });
    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_ShowEmptyWishlist_When_CustomerLogsIn()
    {
        $artwork = Artwork::visible()->first();
        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->visit('/')
                    ->assertSee('My Wishlist')
                    ->clickLink('My Wishlist')
                    ->assertSee('There is nothing in your wishlist! View artwork and add it to start making your wishlist.');
        });
        $this->deleteWishlistForCustomer($user->id);
        $this->logout();
    }


    /**
     * @group wishlists
     * @return void
     */
    public function testShould_ShowArtworkInWishlist_When_CustomerAddsArtwork()
    {
        $artwork = Artwork::visible()->first();
        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->visit('/')
                    ->assertSee('My Wishlist')
                    ->clickLink('My Wishlist')
                    ->assertDontSee($artwork->title)
                    ->assertSee('There is nothing in your wishlist! View artwork and add it to start making your wishlist.')
                    ->visit('/artworks/' . $artwork->id)
                    ->clickLink('Add to my Wishlist')
                    ->assertPathIs('/wishlists/my_wishlist')
                    ->assertSee($artwork->title);
        });
        $this->deleteWishlistForCustomer($user->id);
        $this->logout();
    }


    /**
     * @group wishlists
     * @return void
     */
    public function testShould_ShowArtworkOnce_When_GuestAddsArtworkToTheWishlistTwice()
    {
        $artwork = Artwork::visible()->first();
        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);

        $this->browse(function (Browser $browser) use ($artwork) {
            $browser->visit('/artworks/' . $artwork->id)
                    ->clickLink('Add to my Wishlist')
                    ->visit('/artworks/' . $artwork->id)
                    ->clickLink('Add to my Wishlist')
                    ->assertPathIs('/wishlists/my_wishlist')
                    ->assertSee('Artwork already added to your wishlist');
        });
        $this->deleteWishlistForCustomer($user->id);
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

    private function deleteWishlistForCustomer($customer_id)
    {
        $wishlist = Wishlist::where('customer_id', '=', $customer_id)->first();
        if($wishlist != NULL)
        {
            //delete the items from the wishlist
            DB::table('artwork_wishlists')->where('wishlist_id', '=', $wishlist->id)->delete();
            DB::table('wishlists')->where('id', '=', $wishlist->id)->delete();
        }
    }


}


