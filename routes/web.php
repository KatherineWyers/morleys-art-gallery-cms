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


Auth::routes();
Route::get('/home', function () {
    return redirect('/');
});


Route::get('/', ['as' => 'web-portal.frontpage', 'uses' => 'PagesController@frontpage']);


Route::resource('artworks', 'ArtworksController');
Route::get('/artworks/c/{category_id}', 'ArtworksController@index');
Route::get('/artworks/max-price/{max_price}', 'ArtworksController@indexUnderMaxPrice');
Route::get('/artworks/{id}/{img?}', 'ArtworksController@show');

Route::resource('artists', 'ArtistsController');

Route::get('/exhibitions/by-year/{yyyy}', 'ExhibitionsController@indexByYear');
Route::resource('exhibitions', 'ExhibitionsController');

Route::resource('news_articles', 'NewsArticlesController');

Route::get('/gallery', function () {
    return view('web-portal/gallery');
});

Route::get('/contact', function () {
    return view('web-portal/contact');
});


Route::get('/ims', 'ImsController@home');

Route::get('/ims/pos/{artwork_id}', 'SalesController@create');
Route::post('/ims/sales', 'SalesController@store');
Route::get('/ims/sales', 'SalesController@index');