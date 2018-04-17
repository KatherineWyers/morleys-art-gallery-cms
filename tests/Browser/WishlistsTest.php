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

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_SendWishlist_When_CustomerSendsEmail()
    {
        $artwork1 = Artwork::visible()->first();
        $artwork2 = Artwork::visible()->skip(1)->first();
        $artwork3 = Artwork::visible()->skip(2)->first();

        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);

        $this->browse(function (Browser $browser) use ($artwork1, $artwork2, $artwork3) {
            $browser->visit('/artworks/' . $artwork1->id)
                    ->clickLink('Add to my Wishlist')
                    ->visit('/artworks/' . $artwork2->id)
                    ->clickLink('Add to my Wishlist')
                    ->visit('/artworks/' . $artwork3->id)
                    ->clickLink('Add to my Wishlist')
                    ->assertPathIs('/wishlists/my_wishlist')
                    ->assertSee('Send Wishlist')
                    ->type('name', 'Thomas Jones')
                    ->type('email', 'katherinewyers1@gmail.com')
                    ->click('input[type="submit"]')
                    ->assertPathIs('/wishlists/my_wishlist')
                    ->assertSee('Your wishlist was sent successfully!');
        });

        $this->deleteWishlistForCustomer($user->id);
        $this->logout();
    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_CreateLinkToWishlistReadyToSend_When_CustomerCreatesWishlist()
    {
        $artwork1 = Artwork::visible()->first();
        $artwork2 = Artwork::visible()->skip(1)->first();
        $artwork3 = Artwork::visible()->skip(2)->first();

        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);

        $this->browse(function (Browser $browser) use ($artwork1, $artwork2, $artwork3) {
            $browser->visit('/artworks/' . $artwork1->id)
                    ->clickLink('Add to my Wishlist')
                    ->visit('/artworks/' . $artwork2->id)
                    ->clickLink('Add to my Wishlist')
                    ->visit('/artworks/' . $artwork3->id)
                    ->clickLink('Add to my Wishlist');
        });

        $wishlist = $this->getWishlist($user->id);

        $this->logout();

        $this->browse(function (Browser $browser) use ($wishlist, $artwork1, $artwork2, $artwork3) {
            $browser->visit('/wishlists/' . $wishlist->id)
                    ->assertSee($artwork1->title)
                    ->assertSee($artwork2->title)
                    ->assertSee($artwork3->title);
        });

        $this->deleteWishlist($wishlist);
    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_SellArtwork_When_FriendOfCustomerClicksPurchaseOnWishlist()
    {
        $artwork = Artwork::visible()->first();

        $user = $this->loginAsCustomer();
        $this->deleteWishlistForCustomer($user->id);
        $wishlist = $this->createWishlistForCustomer($user->id);
        $wishlist->artworks()->save($artwork);
        $this->logout();

        $this->browse(function (Browser $browser) use ($wishlist, $artwork, $user) {
            $browser->visit('/wishlists/' . $wishlist->id)
                    ->assertSee($artwork->title)
                    ->assertSee('Buy')
                    ->clickLink('Buy')
                    ->assertPathIs('/pos/w/' . $artwork->id . '/' . $wishlist->id)
                    ->assertSee($user->name)
                    ->assertSee($artwork->title)
                    ->assertSee($artwork->price)
                    ->type('purchaser_name', 'Jane Doe')
                    ->type('purchaser_email', 'katherinewyers1@gmail.com')
                    ->type('cc_name', 'Jane Doe')
                    ->type('cc_number', '4444333322221111')
                    ->type('cc_exp_mm', '01')
                    ->type('cc_exp_yyyy', '2020')
                    ->type('cc_cvv', '123')
                    ->click('input[type="submit"]')
                    ->assertSee('Item purchased successfully. It is now available for collection by ' . $user->name . ' at the gallery. Thank you')
                    ->visit('/wishlists/' . $wishlist->id)
                    ->assertSee($artwork->title)
                    ->assertDontSee('Buy')
                    ->assertSee('Item No Longer Available');
        });

        $this->deleteWishlist($wishlist);
    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_ShowArtworkInWishlistButNotShowBuyButton_When_ArtworkInWishlistHasAlreadyBeenSold()
    {

    }

    /**
     * @group wishlists
     * @return void
     */
    public function testShould_RedirectToWishlistAndShowNotification_When_SoldArtworkLinkUsed()
    {

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

    private function createWishlistForCustomer($customer_id)
    {
        return Wishlist::create(['customer_id' => $customer_id]);
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

    private function deleteWishlist($wishlist)
    {
        DB::table('artwork_wishlists')->where('wishlist_id', '=', $wishlist->id)->delete();
        DB::table('wishlists')->where('id', '=', $wishlist->id)->delete();
    }

    private function getWishlist($customer_id)
    {
        $wishlist = Wishlist::where('customer_id', '=', $customer_id)->first();
        if($wishlist == NULL)
        {
            $wishlist = Wishlist::create(['customer_id' => $customer_id]);
        }
        return $wishlist; 
    }

}


