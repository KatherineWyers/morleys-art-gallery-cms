<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Artwork;
use App\User;
use App\OnlineSale;

class OnlineSalesTest extends DuskTestCase
{
    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_PromptForLogin_When_GuestTriesToMakeAnOnlinePurchase()
    {
        $artwork = Artwork::visible()->first();

        $this->browse(function ($browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
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
    public function test_Should_ProcessSaleOfArtwork_When_CustomerTriesToMakeAnOnlinePurchase()
    {
        $artwork = Artwork::visible()->first();
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($artwork, $user) {
            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
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
                    ->click('input[name="submit"]')
                    ->assertSee('Item purchased successfully. It is now available for collection by ' . $user->name . ' at the gallery. Thank you')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertPathIs('/artworks')
                    ->assertSee('The requested artwork is no longer available');
        });
        $this->logout();  
    }


    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_HideArtworkFromFeaturedArtworks_When_CustomerBuysTheArtwork()
    {
        $artwork=Artwork::visible()->orderBy('created_at', 'desc')->first();
        $user = $this->loginAsCustomer();
        $this->browse(function ($browser) use ($artwork, $user) {
            $browser->resize(1366, 768)
                    ->visit('/')
                    ->assertSee($artwork->title)
                    ->visit('/artworks/' . $artwork->id)
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
                    ->click('input[name="submit"]')
                    ->assertSee('Item purchased successfully. It is now available for collection by ' . $user->name . ' at the gallery. Thank you')
                    ->visit('/artworks/' . $artwork->id)
                    ->assertPathIs('/artworks')
                    ->assertSee('The requested artwork is no longer available')
                    ->visit('/')
                    ->assertDontSee($artwork->title);
        });
        $this->logout();  
    }




    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_ShowNotificationOnImsDashboard_When_NoOnlineSalesAreAwaitingCollection()
    {
        $uncollected_online_sales = OnlineSale::uncollected()->get();

        //temporarily mark as collected
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = TRUE;
            $online_sales->save();
        }

        //assert that there is no artwork awaiting collection 
        $user = $this->loginAsStaff();
        $this->browse(function ($browser) {
            $browser->resize(1366, 768)
                    ->visit('/ims')
                    ->assertSee('Online Sales Awaiting Collection')
                    ->assertSee('No online-sales awaiting collection');
        });
        $this->logout();  

        //reset to previous state
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = FALSE;
            $online_sales->save();
        }

    }


    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_ShowOnlineSaleOnImsDashboardAsAwaitingCollection_When_ArtworkIsSoldOnline()
    {
        $uncollected_online_sales = OnlineSale::uncollected()->get();

        //temporarily mark as collected
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = TRUE;
            $online_sales->save();
        }

        $artwork = Artwork::visible()->first();
        $customer = $this->loginAsCustomer();
        $this->createOnlineSale($customer, $artwork);
        $this->logout();   

        $user = $this->loginAsStaff();
        $this->browse(function ($browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/ims')
                    ->assertSee('Online Sales Awaiting Collection')
                    ->assertDontSee('No online-sales awaiting collection')
                    ->assertSee($artwork->title)
                    ->assertSee('Show');
        });
        $this->logout();   

        //reset to previous state
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = FALSE;
            $online_sales->save();
        }

    }


    /**
     * @group online-sales
     *
     * @return void
     */
    public function test_Should_MarkOnlineSaleAsCollected_When_StaffMemberSelectsMarkAsCollected()
    {
        $uncollected_online_sales = OnlineSale::uncollected()->get();

        //temporarily mark as collected
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = TRUE;
            $online_sales->save();
        }

        $artwork = Artwork::visible()->first();
        $customer = $this->loginAsCustomer();
        $this->createOnlineSale($customer, $artwork);
        $this->logout();   

        $user = $this->loginAsStaff();
        $this->browse(function ($browser) use ($artwork) {
            $browser->resize(1366, 768)
                    ->visit('/ims')
                    ->assertSee('Online Sales Awaiting Collection')
                    ->assertDontSee('No online-sales awaiting collection')
                    ->assertSee($artwork->title)
                    ->assertSee('Show')
                    ->clickLink('Show')
                    ->assertSee('Mark As Collected')
                    ->clickLink('Mark As Collected')
                    ->assertSee('The online sale was marked as collected')
                    ->assertDontSee('Mark As Collected')
                    ->visit('/ims')
                    ->assertDontSee($artwork->title)
                    ->assertSee('No online-sales awaiting collection');
        });
        $this->logout();   

        //reset to previous state
        foreach($uncollected_online_sales as $online_sales)
        {
            $online_sales->collected = FALSE;
            $online_sales->save();
        }

    }



    private function createOnlineSale($customer, $artwork)
    {
        $artwork->visible = FALSE;
        $artwork->save();
        return OnlineSale::create(['purchaser_name' => $customer->name, 'purchaser_email' => $customer->email, 'customer_id' => $customer->id, 'artwork_id' => $artwork->id]);
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
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
