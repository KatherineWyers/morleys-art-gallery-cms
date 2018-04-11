<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // make the manager
        factory(App\User::class)->create(['role' => 'Manager', 'email' => 'manager@morleysgallery.com']);

        // make the staff-members
        factory(App\User::class)->create(['role' => 'Admin', 'email' => 'staff1@morleysgallery.com']);
        factory(App\User::class)->create(['role' => 'Admin', 'email' => 'staff2@morleysgallery.com']);
        factory(App\User::class)->create(['role' => 'Admin', 'email' => 'staff3@morleysgallery.com']);

        // make the customers
        factory(App\User::class)->create(['email' => 'customer1@gmail.com']);
        factory(App\User::class)->create(['email' => 'customer2@gmail.com']);
        factory(App\User::class)->create(['email' => 'customer3@gmail.com']);
        factory(App\User::class)->create(['email' => 'customer4@gmail.com']);
        factory(App\User::class)->create(['email' => 'customer5@gmail.com']);
        factory(App\User::class)->create(['email' => 'customer6@gmail.com']);
    }
}
