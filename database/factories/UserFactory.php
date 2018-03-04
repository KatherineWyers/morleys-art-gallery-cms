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

$factory->define(App\Artwork::class, function (Faker $faker) {
    return [
        'title' => $faker->text(20),
        'artist_id' => 1,
        'year_created' => 2017,
        'medium' => 'Oil on canvas',
        'width_cm' => 12.6,
        'height_cm' => 14,
        'width_in' => 5,
        'height_in' => 6,
        'price' => 2400,
        'img_1' => '400x600.png',
        'img_2' => '400x600.png',
        'img_3' => '400x600.png',
        'desc_1' => $faker->text(990),
    ];
});