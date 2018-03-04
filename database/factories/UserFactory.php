<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'featured_artwork_img_lg' => '1240x700.png',
        'featured_artwork_img_sm' => '300x300.png',
        'profile_img' => '400x600.png',
        'desc_1' => $faker->text(990),
        'desc_2' => $faker->text(990),
    ];
});
