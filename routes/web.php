<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/awb/excel', 'AwbController@index');
Route::post('/awb/import','AwbController@import');
Auth::routes();
Route::get('/','Auth\LoginController@showLoginForm');
Route::get('/user/{user}/edit', 'Auth\RegisterController@edit');
Route::patch('/user/{user}', 'Auth\RegisterController@update');
Route::delete('/user/{user}', 'Auth\RegisterController@destroy');

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@home');
Route::get('/dealer', 'DealerController@index');
Route::get('/add-dealer', 'DealerController@tambah');
Route::post('/dealer/store', 'DealerController@store');
Route::get('/dealer/{dealer}/edit', 'DealerController@edit');
Route::patch('/dealer/{dealer}', 'DealerController@update');
Route::delete('/dealer/{dealer}', 'DealerController@destroy');
Route::get('/cari', 'DealerController@cari');
Route::post('/selected', 'DealerController@selected')->name('selected');
Route::post('/rayon', 'DealerController@rayon')->name('rayon');
Route::get('/importawb', 'HomeController@import');

Route::get('/summary', 'SummaryController@index');
Route::get('/detail/{dds}/{kota}', 'SummaryController@detail');

Route::get('/delivery/cari/', 'DeliveryController@cari');
Route::put('/delivery/store', 'DeliveryController@store');
// Route::get('/delivery/search/', 'DeliveryController@liveSearch')->name('liveSearch');
Route::get('/delivery', 'DeliveryController@index');
Route::get('/delivery/detail/{no_awb}', 'DeliveryController@detail');
Route::get('/delivery/edit/{no_awb}', 'DeliveryController@edit');
// Route::get('/delivery/filter/','DeliveryController@liveFilter')->name('liveFilter');

Route::get('/tracking', 'TrackingController@index');
// Route::get('/coba', 'TrackingController@update');
Route::post('/tracking/update', 'TrackingController@update');