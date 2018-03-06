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
        factory(App\User::class)->create(['email' => 'staff1@morleysgallery.com']);
        factory(App\User::class)->create(['email' => 'staff2@morleysgallery.com']);
        factory(App\User::class)->create(['email' => 'staff3@morleysgallery.com']);
    }
}
