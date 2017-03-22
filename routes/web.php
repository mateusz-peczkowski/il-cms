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
    Route::get('users/{id}/deactivate', 'UsersController@deactivate')->name('users.deactivate');
    Route::get('users/{id}/activate', 'UsersController@activate')->name('users.activate');
    Route::get('users/{id}/delete', 'UsersController@delete')->name('users.delete');
    Route::post('/users/addavatar', 'UsersController@addavatar')->name('user.addavatar');

    Route::get('trash', 'TrashController@index')->name('trash');
    Route::get('trash/{module}/{id}/revoke', 'TrashController@revoke')->name('trash.revoke');
    Route::get('trash/{module}/{id}/destroy', 'TrashController@destroy')->name('trash.destroy');

    Route::get('changelog', 'ChangelogController@index')->name('changelog');
    Route::get('documentation', 'DocumentationController@index')->name('documentation');

});
