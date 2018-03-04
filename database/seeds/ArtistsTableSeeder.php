<?php

use Illuminate\Database\Seeder;
use App\Artist;
use App\Artwork;
use App\ArtworkCategory;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 40; $i++) {
            $artist = factory(App\Artist::class)->create([]);
            for ($j = 0; $j <= 4; $j++) {
                $artwork = factory(App\Artwork::class)->create(['artist_id' => $artist->id]);

                $used_categories = array();
                for($k = 0; $k <= rand(1,3); $k++){
                    $category_id = rand(1,5);
                    // ensure that the same category_id isn't assigned to the same artwork twice
                    if(!in_array($category_id, $used_categories)) {
                        ArtworkCategory::create(['artwork_id' => $artwork->id, 'category_id' => $category_id]);
                        array_push($used_categories, $category_id);    
                    }
                }
            } 
        } 
    }
}
