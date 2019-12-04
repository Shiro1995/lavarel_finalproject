<?php

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

Route::get('v1/mobile/get/pharmacies', 'API\PharmacyController@get_pharmacy')->name('get_pharmacies');

Route::get('v1/mobile/get/diseases', 'API\DiseaseController@get_diseases')->name('get_diseases');

Route::group(['middleware' => ['jwt.auth']], function() {
    /**
     * Example to get data with access token
     * php artian route:list => see structure of /vi/mobile/book
     * Assume GET
     * Request: Header: Authorization
     *          Param: Bearer<Space><Token>
     */
});
