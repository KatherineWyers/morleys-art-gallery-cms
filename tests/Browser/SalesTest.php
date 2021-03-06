<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Artwork;
use App\Sale;
use App\OnlineSale;

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

            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->clickLink('Process Sale')
                    ->type('name', 'James Godfrey')
                    ->type('email', 'jgodfrey@gmail.com')
                    ->type('phone_number', '0123456')
                    ->type('amount', $sale_price)//sell the item at a 100 pound discount
                    ->click('input[name="submit"]')
                    ->assertSee('Month: ' . $year . '-' . $month .', Total Items Sold: ' . $expected_item_count . ', Sales: ' . $expected_sales_figure)
                    ->assertSee('Sale processed successfully')
                    ->visit('/artworks/' . $artwork->id)//attempt to visit the artwork public page
                    ->assertPathIs('/artworks')
                    ->assertSee('The requested artwork is no longer available');
        });

        $this->logout();

    }




    /**
     * System test for the sales process
     * @group ims
     * @return void
     */
    public function test_Should_ProcessSale_When_StaffMakesSale()
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

            //set the expected sales report
            $expected_sales_figure = $sales_figure_before_this_sale + $artwork->price;
            $expected_item_count = $item_count_before_this_sale + 1;

            $browser->resize(1366, 768)
                    ->visit('/artworks/' . $artwork->id)
                    ->clickLink('Process Sale')
                    ->type('name', 'James Godfrey')
                    ->type('email', 'jgodfrey@gmail.com')
                    ->type('phone_number', '0123456')
                    ->type('amount', $artwork->price)//sell the item at a 100 pound discount
                    ->click('input[name="submit"]')
                    ->assertSee('Month: ' . $year . '-' . $month .', Total Items Sold: ' . $expected_item_count . ', Sales: ' . $expected_sales_figure)
                    ->assertSee('Sale processed successfully')
                    ->visit('/artworks/' . $artwork->id)//attempt to visit the artwork public page
                    ->assertPathIs('/artworks')
                    ->assertSee('The requested artwork is no longer available');
        });

        $this->logout();

    }




    /**
     * @group ims
     * @return void
     */
    public function test_Should_ShowFormattedSalesDetailsInList_When_UserIsStaff()
    {
        $sale_1 = Sale::orderBy('created_at', 'desc')->first();
        $sale_2 = Sale::orderBy('created_at', 'desc')->skip(1)->first();
        $online_sale_1 = OnlineSale::orderBy('created_at', 'desc')->first();
        $online_sale_2 = OnlineSale::orderBy('created_at', 'desc')->skip(1)->first();

        $this->loginAsStaff();
        $this->browse(function ($browser) use ($sale_1, $sale_2, $online_sale_1, $online_sale_2) {
            

            $browser->resize(1366, 768)
                    ->visit('/')
                    ->visit('/ims/sales/list')
                ->assertSee($this->convertDatetimeStringToFormattedDate($sale_1->created_at) . ': ' . $sale_1->artwork->title . ': In-person Sale: £' . $sale_1->amount)
                ->assertSee($this->convertDatetimeStringToFormattedDate($sale_2->created_at) . ': ' . $sale_2->artwork->title . ': In-person Sale: £' . $sale_2->amount)
                ->assertSee($this->convertDatetimeStringToFormattedDate($online_sale_1->created_at) . ': ' . $online_sale_1->artwork->title . ': Online Sale: £' . $online_sale_1->artwork->price)
                ->assertSee($this->convertDatetimeStringToFormattedDate($online_sale_2->created_at) . ': ' . $online_sale_2->artwork->title . ': Online Sale: £' . $online_sale_2->artwork->price);
        });


        $this->logout();
    }

    private function convertDatetimeStringToFormattedDate($datetime_string)
    {
        return Carbon::parse($datetime_string)->toRfc7231String();
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
            $browser->resize(1366, 768)
                    ->visit('/ims/sales')
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
            $browser->resize(1366, 768)
                    ->visit('/ims/sales')
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

            $browser->resize(1366, 768)
                    ->visit('/ims/sales')
                ->assertSee('Name: ' . $user1->name)
                ->assertSee('Name: ' . $user2->name);
        });
        $this->logout();
    }

    /**
     * @return void
     */
    public function test_Should_ShowInPersonSalesContract_When_UserIsStaff()
    {
        $this->loginAsManager();

        $in_person_sale = Sale::all()->first();

        $this->browse(function ($browser) use ($in_person_sale)
            {
                $browser->resize(1366, 768)
                    ->visit('/ims/sales/' . $in_person_sale->id)
                    ->assertSee('Sale')
                    ->assertSee($in_person_sale->artwork->title);  
                 
            });
        
        $this->logout();
    }

    /**
     * @group ims
     * @return void
     */
    public function test_Should_ShowOnlineSalesContract_When_UserIsStaff()
    {
        $this->loginAsManager();

        $online_sale = OnlineSale::all()->first();
        $this->browse(function ($browser) use ($online_sale)
            {
                $browser->resize(1366, 768)
                    ->visit('/ims/sales/online/' . $online_sale->id)
                    ->assertSee('Online Sale')
                    ->assertSee($online_sale->artwork->title);  
                 
            });
        $this->logout();
    }

    private function loginAsStaff() {
        $this->browse(function ($browser) {

            $user = User::Admins()->first();

            $browser->resize(1366, 768)
                    ->visit('/')
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

            $browser->resize(1366, 768)
                    ->visit('/')
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
            $browser->resize(1366, 768)
                    ->visit('/logout')
                    ->logout()
                    ->assertDontSee("IMS");
        }); 
    }
}
