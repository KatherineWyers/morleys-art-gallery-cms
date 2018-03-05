<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NewsArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        // NewsArticles over the last three years
        for ($i = 0; $i <= 50; $i++) {
            $created_at = Carbon::createFromTimeStamp($faker->dateTimeBetween('-699 days', '-1 days')->getTimestamp());
            factory(App\NewsArticle::class)->create(['created_at' => $created_at, 'updated_at' => $created_at]);
        } 
    }
}
