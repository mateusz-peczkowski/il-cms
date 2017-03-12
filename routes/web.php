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

// Home page
Route::get('/', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Admin panel Routes
Route::group(['middleware' => 'auth', 'namespace' => 'cmsbackend', 'prefix' => 'cmsbackend'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('users', 'UsersController', ['except' => ['show'], 'names' => ['index' => 'users']]);
    Route::post('/users/editcurrent', 'UsersController@editcurrent')->name('user.editcurrent');
});
