<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

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
        'year_created' => rand(2000,2018),
        'medium' => 'Oil on canvas',
        'width_cm' => rand(5.0,20.0),
        'height_cm' => rand(5.0,20.0),
        'width_in' => rand(5.0,20.0),
        'height_in' => rand(5.0,20.0),
        'price' => (rand(5,100) * 100),
        'img_1' => '400x600.png',
        'img_2' => '400x600.png',
        'img_3' => '400x600.png',
        'img_sq' => '300x300.png',
        'desc_1' => $faker->text(990),
    ];
});

$factory->define(App\Exhibition::class, function (Faker $faker) {
        $date_today = date('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $date_today)->addDays(20); 

    return [
        'title' => $faker->text(20),
        'start_date' => $date_today,
        'end_date' => $end_date,
        'desc_1' => $faker->text(990),
        'img_1' => '1200x300.png',
        'img_2' => '600x300.png',
    ];
});

$factory->define(App\NewsArticle::class, function (Faker $faker) {
        $date_today = date('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $date_today)->addDays(20); 

    return [
        'title' => $faker->text(20),
        'content' => $faker->text(990),
        'img_1' => '300x300.png',
    ];
});