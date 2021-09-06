<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/getfinalawb','ApiController@getFinalAwb');
Route::post('/coba','ApiController@coba');
Route::post('/login','ApiController@login');//api buat login
Route::post('/getawb','ApiController@getAwb');//api buat scan awb
Route::post('/getproforma','ApiController@getProforma');//api buat scan awb
Route::post('/getdealer','ApiController@getDealer');//api buat scan awb
Route::post('/storeawb','ApiController@storeAwb');//api buat simpan awb
Route::post('/storeproforma','ApiController@storeProforma');//api buat simpan proforma
Route::post('/storeallproforma','ApiController@storeAllProforma');//api buat simpan proforma
Route::post('/storeimage','ApiController@storeImage');//api buat scan awb