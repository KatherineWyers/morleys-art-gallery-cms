<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('web-portal/frontpage');
});

Route::get('/artworks', function () {
    return view('web-portal/artworks/menu');
});

Route::get('/artworks/1', function () {
    return view('web-portal/artworks/show');
});

Route::get('/artworks/2', function () {
    return view('web-portal/artworks/show');
});

Route::resource('artists', 'ArtistsController');

// Route::get('/artists', function () {
//     return view('web-portal/artists/index');
// });

// Route::get('/artists/1', function () {
//     return view('web-portal/artists/show');
// });

Route::get('/gallery', function () {
    return view('web-portal/gallery');
});

Route::get('/contact', function () {
    return view('web-portal/contact');
});

Route::get('/exhibitions', function () {
    return view('web-portal/exhibitions/index');
});

Route::get('/exhibitions/1', function () {
    return view('web-portal/exhibitions/show');
});

Route::get('/exhibitions/past/2015', function () {
    return view('web-portal/exhibitions/past/index');
});

Route::get('/exhibitions/past/2016', function () {
    return view('web-portal/exhibitions/past/index');
});

Route::get('/exhibitions/past/2017', function () {
    return view('web-portal/exhibitions/past/index');
});

Route::get('/news', function () {
    return view('web-portal/news/index');
});



