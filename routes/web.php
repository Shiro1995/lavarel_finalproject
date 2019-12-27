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

/**
 * Import content inside Laravel Framework
 * Auth: point using object Authenticate in Laravel.
 * Route: point using object Route and allow you to navigate all other directions
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Using this Lib for tracking Log error from System
 * Laravel Log Viewer
 */

Route::group(['prefix' => '', 'note' => 'LOG'], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/admin', 'Dashboard\DashboardController');
    Route::resource('/admin/module/category', 'Dashboard\CategoryController');
    Route::resource('/admin/module/disease', 'Dashboard\DiseaseController');
    Route::resource('/admin/module/type_disease', 'Dashboard\TypeDiseaseController');
    Route::resource('/admin/module/definitions', 'Dashboard\DefinitionsController');
    Route::resource('/admin/module/prognostics', 'Dashboard\PrognosticsController');
    Route::resource('/admin/module/reasons', 'Dashboard\ReasonsController');
    Route::post('/admin/module/category/{category}', 'Dashboard\Categorycontroller@update')->name('category.update');
    Route::post('/admin/module/disease/{disease}', 'Dashboard\Diseasecontroller@update')->name('disease.update');

    /*
     * Custom specify route with specific URL.
     * - Make LogoutController inside folder Dashboard. php artisan make:controller Dashboard\LogoutController
     * - Check by command: php artisan route:list
     */
    Route::post('logout', 'Dashboard\LogoutController@logout')->name('logout');

    /*
     * Similarity with CRUD for User, Doctor, Disease, Pharmacy,...
     */
    Route::resource('/user', 'Dashboard\UserController');

    /*
     * Using Ajax to navigate page
     */
    Route::get('/admin/v1/disease/', 'API\Diseasecontroller@getDisease')->name('get_disease');

    Route::get('/admin/v1/pharmacy/', 'API\Pharmacycontroller@getPharmacy')->name('get_pharmacy');

    Route::get('/admin/v1/definitions/', 'API\Definitionscontroller@getDefinitions')->name('get_symptom');

    Route::get('/admin/ajax/definitions', 'Navigation\NavigationController@definitions')->name('ajax.definitions');

    Route::get('/admin/ajax/prognostics', 'Navigation\NavigationController@prognostics')->name('ajax.prognostics');

    Route::get('/admin/ajax/reasons', 'Navigation\NavigationController@reasons')->name('ajax.reasons');

    Route::get('/admin/ajax/category', 'Navigation\NavigationController@category')->name('ajax.category');

    Route::get('/admin/ajax/disease', 'Navigation\NavigationController@disease')->name('ajax.disease');

    Route::get('/admin/ajax/type_disease', 'Navigation\NavigationController@type_disease')->name('ajax.disease');

    Route::get('/admin/ajax/dashboard', 'Navigation\NavigationController@dashboard')->name('ajax.dashboard');
});
