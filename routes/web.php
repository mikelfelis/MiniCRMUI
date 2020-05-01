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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// using middleware for admin routes
Route::middleware('is_admin')->group(function () {
    Route::get('admin/home', 'HomeController@adminHome')->name('admin.home');

    Route::resources([
        'admin/companies' => 'Admin\CompanyController',
        'admin/employees' => 'Admin\EmployeeController'
    ]);
});

// Socialite routes
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');