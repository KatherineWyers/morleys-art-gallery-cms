<?php

use Illuminate\Database\Seeder;
use App\Artist;
use App\Artwork;
use App\ArtworkCategory;
use App\Sale;
use Carbon\Carbon;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i <= 40; $i++) {
            $artist = factory(App\Artist::class)->create([]);
            for ($j = 0; $j <= 4; $j++) {
                //determine whether the item has been sold (25% chance of sale)
                $sold = (rand(1,4)==1);
                $visible = !($sold);
                $artwork = factory(App\Artwork::class)->create(['artist_id' => $artist->id, 'visible' => $visible]);

                if($sold){
                    $has_discount = (rand(1,4)==1);
                    if($has_discount){
                        $amount = $artwork->price - 50;
                    } else {
                        $amount = $artwork->price;
                    }
                    $seller_id = rand(1,4);//manager and staff-members are seeded with ids 1, 2, 3 and 4
                    $created_at = Carbon::createFromTimeStamp($faker->dateTimeBetween('-90 days', '-1 days')->getTimestamp());
                    factory(App\Sale::class)->create(['seller_id' => $seller_id, 'artwork_id' => $artwork->id, 'amount' => $amount, 'created_at' => $created_at, 'updated_at' => $created_at]);                    
                }

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
