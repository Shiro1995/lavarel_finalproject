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

/*
 * Using this Lib for tracking Log error from System
 * Laravel Log Viewer
 */
Route::group(['prefix' => '', 'note' => 'LOG'], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    /**
     * Running Command php artisan make:controller \Dashboard\DashboardController --resource
     * Example other Controller: php artisan make:controller \Dashboard\ProfileController
     * or if you want to create UserController inside folder Dashboard. We have command like below
     * php artisan make:controller \Dashboard\UserController --resource
     */
    Route::resource('/admin', 'Dashboard\DashboardController');
    Route::resource('/admin/module/category', 'Dashboard\CategoryController');
    Route::resource('/admin/module/disease', 'Dashboard\DiseaseController');
    Route::resource('/admin/module/symptom', 'Dashboard\SymptomController');
    Route::post('/admin/module/category/{category}', 'Dashboard\Categorycontroller@update')->name('category.update');
    Route::post('/admin/module/disease/{disease}', 'Dashboard\Diseasecontroller@update')->name('disease.update');
    Route::post('/admin/module/symptom/{symptom}', 'Dashboard\SymptomController@update')->name('symptom.update');
    Route::post('/admin/module/symptom/disease/{disease}/', 'Dashboard\Symptomcontroller@addSymptom')->name('dis_symptom.create');

    /**
     * Now, we will use run command php artisan route:list
     *
     * /admin => GET => admin.index => Point function index() in DashboardController. If you use this URL and you will
     * get page HTML or view from resource. You can completely attach data inside view and load it to end-user
     *
     * /admin => POST => admin.store => Get Request from Form when you want use a form  to submit your data and save data to
     * local storage. For example, Login Form or Register Form.
     *
     * /admin => admin.create() => admin.create => point method create() and allow you load page View and enter data on it.
     *
     * /admin{admin} => GET/DELETE => Using param from URL admin (you pass ID or anything) to do your manipulation such as Delete, Search, ...
     *
     * Summarize: We have CRUD => create, update and delete.
     * Let's do an example to know how it works.
     *
     * Notes:
     * To know exactly what method (create, index, update, store where are???). Let visit DashboardController.php in app folder.
     */

    /**
     * Custom specify route with specific URL.
     * - Make LogoutController inside folder Dashboard. php artisan make:controller Dashboard\LogoutController
     * - Check by command: php artisan route:list
     */
    Route::post('logout', 'Dashboard\LogoutController@logout')->name('logout');

    /* Similarity with CRUD for User, Doctor, Disease, Pharmacy,... */
    Route::resource('/user', 'Dashboard\UserController');

    /* Using Ajax to navigate page */
    Route::group(['prefix' => ''], function () {
        Route::get('/admin/v1/disease/', 'API\Diseasecontroller@getDisease')->name('get_disease');

        Route::get('/admin/v1/pharmacy/', 'API\Pharmacycontroller@getPharmacy')->name('get_pharmacy');

        Route::get('/admin/v1/symptom/', 'API\Symptomcontroller@getSymptom')->name('get_symptom');

        Route::get('/admin/module/disease/symptom/{disease}/', 'Dashboard\Diseasecontroller@showSymptom')->name('dis_symptom.update');

        Route::get('admin/ajax/symptom', 'Navigation\NavigationController@symptom')->name('ajax.symptom');

        Route::get('admin/ajax/category', 'Navigation\NavigationController@category')->name('ajax.category');

        Route::get('admin/ajax/disease', 'Navigation\NavigationController@disease')->name('ajax.disease');

        Route::get('admin/ajax/dashboard', 'Navigation\NavigationController@dashboard')->name('ajax.dashboard');

        Route::get('admin/ajax/type_disease', 'Navigation\NavigationController@type_disease')->name('ajax.type_disease');
    });
});
