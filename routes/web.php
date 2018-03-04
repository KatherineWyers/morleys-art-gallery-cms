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

Route::get('/', ['as' => 'web-portal.frontpage', 'uses' => 'PagesController@frontpage']);

Route::resource('artworks', 'ArtworksController');
Route::resource('artists', 'ArtistsController');

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



