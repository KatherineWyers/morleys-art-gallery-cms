<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Artwork;

class SalesTest extends DuskTestCase
{
    /**
     * System test for the sales process
     * @group ims
     * @return void
     */
    public function test_Should_UpdateSalesReport_When_StaffMakesSale()
    {
        $this->loginAsStaff();

        $this->browse(function ($browser) {

            $user = User::Admins()->first();
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $sales_report = $user->sales_report($year, $month);
            $sales_figure_before_this_sale = $sales_report->salesFigure();
            $item_count_before_this_sale = $sales_report->itemCount();

            //make the sale
            $artwork = Artwork::where('visible', TRUE)->first();
            $sale_price = $artwork->price - 100;

            //set the expected sales report
            $expected_sales_figure = $sales_figure_before_this_sale + $sale_price;
            $expected_item_count = $item_count_before_this_sale + 1;

            $browser->visit('/artworks/' . $artwork->id)
                    ->clickLink('Process Sale')
                    ->type('name', 'James Godfrey')
                    ->type('email', 'jgodfrey@gmail.com')
                    ->type('phone_number', '0123456')
                    ->type('amount', $sale_price)//sell the item at a 100 pound discount
                    ->click('input[type="submit"]')
                    ->assertSee('Month: ' . $year . '-' . $month .', Total Items Sold: ' . $expected_item_count . ', Sales: ' . $expected_sales_figure)
                    ->visit('/artworks/' . $artwork->id)//attempt to visit the artwork public page
                    ->assertPathIs('/');//assert that the sold artwork redirects to the homepage
        });

        $this->logout();

    }

    /**
     * @group ims
     * @return void
     */
    public function test_Should_ShowSalesReportForUser_When_UserIsStaff()
    {

        $this->loginAsStaff();

        $this->browse(function ($browser) {
            $user = User::Admins()->first();
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $browser->visit('/ims/sales')
                ->assertSee('Name: ' . $user->name)
                ->assertSee($user->sales_report($year, $month)->toString());
        });


        $this->logout();
    }

    /**
     * @group ims
     * @return void
     */
    public function test_Should_NotShowSalesReportForAnotherUser_When_UserIsStaff()
    {
        $this->loginAsStaff();

        $this->browse(function ($browser) {
            $user = User::Admins()->first();
            $another_user = User::Admins()->skip(1)->first();//get second Admin. 
            $browser->visit('/ims/sales')
                    ->assertSee('Name: ' . $user->name)
                    ->assertDontSee('Name: ' . $another_user->name);
        });
        $this->logout();
    }

    /**
     * @group ims
     * @return void
     */
    public function test_Should_ShowSalesReportForAllUsers_When_UserIsManager()
    {
        $this->loginAsManager();
        $this->browse(function ($browser) {

            $user1 = User::AdminsAndManagers()->first();
            $user2 = User::AdminsAndManagers()->skip(1)->first();

            $browser->visit('/ims/sales')
                ->assertSee('Name: ' . $user1->name)
                ->assertSee('Name: ' . $user2->name);
        });
        $this->logout();
    }

    private function loginAsStaff() {
        $this->browse(function ($browser) {

            $user = User::Admins()->first();

            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', $user->email)
                    ->value('#password', 'secret')
                    ->click('button[type="submit"]')
                    ->assertSee("IMS");
        }); 
    }

    private function loginAsManager() {
        $this->browse(function ($browser) {

            $user = User::Managers()->first();

            $browser->visit('/')
                    ->clickLink('Login')
                    ->assertPathIs('/login')
                    ->value('#email', $user->email)
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
}