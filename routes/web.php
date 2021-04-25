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

Route::get('/awb/excel', function () {
    return view('awb.import');
});
Route::post('/awb/import','AwbController@import');
Auth::routes();
Route::get('/','Auth\LoginController@showLoginForm');

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('/summary', 'SummaryController@index');
Route::get('/detail', 'SummaryController@detail');

Route::get('/delivery', 'DeliveryController@index');
Route::get('/delivery/detail/{no_awb}', 'DeliveryController@detail');
