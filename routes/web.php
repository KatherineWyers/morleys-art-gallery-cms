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

//HOMEPAGE: Web-portal
Route::get('/', ['as' => 'web-portal.frontpage', 'uses' => 'PagesController@frontpage']);

//STATIC PAGES: Web-portal
Route::get('/gallery', function () {
    return view('web-portal/gallery');
});

Route::get('/contact', function () {
    return view('web-portal/contact');
});

//ARTWORKS: Web-portal and CMS
Route::resource('artworks', 'ArtworksController');
Route::get('/artworks/c/{category_id}', 'ArtworksController@index');
Route::get('/artworks/max-price/{max_price}', 'ArtworksController@indexUnderMaxPrice');
Route::get('/artworks/{id}/{img?}', 'ArtworksController@show');

//ARTISTS: Web-portal and CMS
Route::resource('artists', 'ArtistsController');

//EXHIBITIONS: Web-portal
Route::get('/exhibitions/by-year/{yyyy}', 'ExhibitionsController@indexByYear');
//Web-portal and CMS
Route::resource('exhibitions', 'ExhibitionsController');

//NEWS ARTICLES: Web-portal and CMS
Route::resource('news_articles', 'NewsArticlesController');

Route::get('/ims', 'ImsController@home');

//SALES: Ims


Route::get('/ims/pos/{artwork_id}', 'SalesController@create');
Route::post('/ims/sales', 'SalesController@store');
Route::get('/ims/sales', 'SalesController@index');

Route::get('/ims/sales/online/mark_as_collected/{online_sale_id}', 'SalesController@markOnlineSaleAsCollected');

Route::get('/ims/sales/total_sales_report/{year?}/{month?}/{tax_rate?}', 'SalesController@totalSalesReport');

Route::get('/ims/sales/list', 'SalesController@list');
Route::get('/ims/sales/online/{id}', 'SalesController@showOnlineSale');
Route::get('/ims/sales/{id}', 'SalesController@showSale');
Route::get('/pos/w/{artwork_id}/{wishlist_id}', 'SalesController@wishlistSale');//wishlist online sale
Route::get('/pos/s/{artwork_id}', 'SalesController@onlineSale');//standard online sale

Route::post('/pos', 'SalesController@storeOnlineSale');

//APPOINTMENTS AND TIMESLOTS: Web

Route::get('/appointments/create/{artwork_id}/{year}/{month}/{date}/{hour}', 'AppointmentsController@create');
Route::post('/appointments', 'AppointmentsController@store');
Route::get('/ims/appointments/delete/{id}', 'AppointmentsController@delete');
Route::get('/ims/appointments/mark_as_sale/{id}', 'AppointmentsController@markAsSale');
Route::get('/ims/appointments/destroy/{id}', 'AppointmentsController@destroy');

Route::get('/ims/appointments/reports', 'AppointmentsController@reports');
Route::get('/ims/appointments/{date?}/{month?}/{year?}', 'AppointmentsController@indexForDate');


Route::get('/timeslots/{artwork_id}/{date?}/{month?}/{year?}', 'TimeslotsController@indexForDate');

//Ims




Route::get('/ims/weekly_timeslots', 'WeeklyTimeslotsController@index');
Route::get('/ims/weekly_timeslots/edit', 'WeeklyTimeslotsController@edit');
Route::post('/ims/weekly_timeslots/edit', 'WeeklyTimeslotsController@update');

Route::get('/ims/visits','VisitsController@index');

Route::get('/wishlists/add/{artwork_id}', 'WishlistsController@addArtwork');
Route::get('/wishlists/my_wishlist', 'WishlistsController@myWishlist');
Route::get('/wishlists/{id}', 'WishlistsController@show');
Route::post('/wishlists', 'WishlistsController@send');

Route::post('/accessibility', 'AccessibilityController@manageCookie');
