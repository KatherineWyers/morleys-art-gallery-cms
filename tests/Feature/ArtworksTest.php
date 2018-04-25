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
    public function test_ArtworksController_GetArtworksFilteredByCategory()
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
}
