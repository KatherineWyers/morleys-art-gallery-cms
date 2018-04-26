<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Artwork;
use App\Category;

class ArtworksTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_ArtworkModel_GetArtworksFilteredByCategory()
    {
    	$match_found = false;
        $categories = Category::all();
        foreach($categories as $category)
        {
        	$artworks = Artwork::getArtworksFilteredByCategory($category->id)->get();

            foreach($artworks as $artwork)
            {
                $match_found = false;
                foreach($artwork->categories as $artwork_category)
                {
                    if($category->id == $artwork_category->id)
                    {
                        $match_found = true;
                        break;
                    }
                }
                if($match_found == false)
                {
                    $this->assertTrue(false);
                    return;
                }
            }
        }
        $this->assertTrue(true);
    }

    /**
     *
     * @return void
     */
    public function test_ArtworkModel_ArtworkFilteredByMaxPrice_ShouldNot_BeInvisibleAndNotBeMoreExpensiveThanMaxPrice()
    {
        $max_prices = array(0, 100, 500, 1000, 2000, 5000, 10000, 20000);

        foreach($max_prices as $max_price)
        {
            $artworks = Artwork::getVisibleArtworksFilteredByMaxPrice($max_price)->get();

            foreach($artworks as $artwork)
            {
                if(($artwork->price > $max_price) || ($artwork->visible == FALSE))
                {
                    $this->assertTrue(false);
                    return;
                }
            }
        }
        $this->assertTrue(true);
    }
}
