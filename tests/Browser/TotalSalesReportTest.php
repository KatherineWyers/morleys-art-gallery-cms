<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Carbon\Carbon;
use App\User;
use App\Artwork;
use App\TotalSalesReport;
use App\MathHelper;

use App\Sale;
use App\OnlineSale;

class TotalSalesReportTest extends DuskTestCase
{
    /**
     * System test for the appointments reporting process
     * @group ims
     * @group total-sales-report
     * @return void
     */
    public function test_Should_UpdateTotalSalesReport_When_SaleAndOnlineSaleAreMade()
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $tax_rate = 20;

        //set environment before sales created
        $seller = User::Admins()->first();
        $artwork = Artwork::visible()->first();
        $total_sales_report = new TotalSalesReport(['year' => $year, 'month' => $month, 'tax_rate' => $tax_rate]);
        $sales_before_sale = $total_sales_report->sales();

        //create sales
        $online_sales_before_sale = $total_sales_report->onlineSales();
        $new_sale = factory(Sale::class)->create(['seller_id' => $seller->id, 'artwork_id' => $artwork->id, 'amount' => $artwork->price]);
        $customer = User::Customers()->first();
        $artwork = Artwork::visible()->first();
        $new_online_sale = factory(OnlineSale::class)->create(['customer_id' => $customer->id, 'artwork_id' => $artwork->id]);

        //expected outcomes
        $expected_sales = $sales_before_sale + $new_sale->amount;
        $expected_online_sales = $online_sales_before_sale + $new_online_sale->artwork->price;
        $expected_total_sales = $expected_sales + $expected_online_sales;
        $expected_tax_rate = $tax_rate;
        $expected_tax_liability = MathHelper::calculatePercentageOfValue($expected_total_sales, $tax_rate);
        $expected_total_sales_less_tax_liability = $expected_total_sales - $expected_tax_liability;

        //test page to see if displayed values are correct
        $this->loginAsManager();
        $this->browse(function ($browser) use ($expected_sales, $expected_online_sales, $expected_total_sales, $expected_tax_rate, $expected_tax_liability, $expected_total_sales_less_tax_liability) {
            $browser->visit('/ims/sales/total_sales_report')
                    ->assertSee('In-person Sales: £' . $expected_sales)
                    ->assertSee('Online Sales: £' . $expected_online_sales)
                    ->assertSee('Total Sales: £' . $expected_total_sales)
                    ->assertSee('Tax Liability (@ ' . $expected_tax_rate . '%) : £' . $expected_tax_liability)
                    ->assertSee('Total Sales Less Tax Liability : £' . $expected_total_sales_less_tax_liability);
        });
        $this->logout();
    }

    private function loginAsManager() 
    {
        $user = User::Managers()->first();
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
