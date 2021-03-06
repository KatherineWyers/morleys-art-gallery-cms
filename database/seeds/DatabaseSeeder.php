<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(DatabaseInitializingSeeder::class);
        $this->call(ArtistsTableSeeder::class);
        $this->call(ExhibitionsTableSeeder::class);
        $this->call(NewsArticlesTableSeeder::class);
    }
}
