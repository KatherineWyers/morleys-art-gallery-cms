<?php

use Illuminate\Database\Seeder;
use App\Category;

class DatabaseInitializingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['id' => 1, 'title' => 'Modern British']);
        Category::create(['id' => 2, 'title' => 'Contemporary']);
        Category::create(['id' => 3, 'title' => 'Prints']);
        Category::create(['id' => 4, 'title' => 'Sculptures']);
        Category::create(['id' => 5, 'title' => 'Ceramics']);
    }
}
