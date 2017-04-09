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
Route::get('/test', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Admin panel Routes
Route::group(['middleware' => 'auth', 'namespace' => 'cmsbackend', 'prefix' => 'cmsbackend'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/lang/{locale}', 'DashboardController@changelocale')->name('changelocale');

    Route::resource('users', 'UsersController', ['except' => ['show', 'create, destroy'], 'names' => ['index' => 'users']]);
    Route::post('/users/editcurrent', 'UsersController@editcurrent')->name('user.editcurrent');
    Route::get('users/{id}/deactivate', 'UsersController@deactivate')->name('users.deactivate');
    Route::get('users/{id}/activate', 'UsersController@activate')->name('users.activate');
    Route::get('users/{id}/delete', 'UsersController@delete')->name('users.delete');
    Route::post('/users/addavatar', 'UsersController@addavatar')->name('user.addavatar');

    Route::resource('settings/redirects', 'RedirectsController', ['except' => ['show', 'create, destroy'], 'names' => ['index' => 'redirects']]);
    Route::get('settings/redirects/{id}/deactivate', 'RedirectsController@deactivate')->name('redirects.deactivate');
    Route::get('settings/redirects/{id}/activate', 'RedirectsController@activate')->name('redirects.activate');
    Route::get('settings/redirects/{id}/delete', 'RedirectsController@delete')->name('redirects.delete');

    Route::resource('settings/translations', 'TranslationsController', ['except' => ['show', 'create, destroy'], 'names' => ['index' => 'translations']]);
    Route::get('settings/translations/{id}/deactivate', 'TranslationsController@deactivate')->name('translations.deactivate');
    Route::get('settings/translations/{id}/activate', 'TranslationsController@activate')->name('translations.activate');
    Route::get('settings/translations/{id}/delete', 'TranslationsController@delete')->name('translations.delete');
    Route::get('settings/translations/{slug}/locale', 'TranslationsController@changelocale')->name('translations.changelocale');
    Route::post('settings/translation/duplicate', 'TranslationsController@duplicate')->name('translations.duplicate');

    Route::resource('settings/languages', 'LanguagesController', ['except' => ['show', 'create, destroy'], 'names' => ['index' => 'languages']]);
    Route::get('settings/languages/{id}/deactivate', 'LanguagesController@deactivate')->name('languages.deactivate');
    Route::get('settings/languages/{id}/activate', 'LanguagesController@activate')->name('languages.activate');
    Route::get('settings/languages/{id}/delete', 'LanguagesController@delete')->name('languages.delete');

    Route::resource('settings/options', 'OptionsController', ['except' => ['show', 'create, destroy'], 'names' => ['index' => 'options']]);
    Route::get('settings/options/{id}/delete', 'OptionsController@delete')->name('options.delete');

    Route::get('trash', 'TrashController@index')->name('trash');
    Route::get('trash/{module}/{id}/revoke', 'TrashController@revoke')->name('trash.revoke');
    Route::get('trash/{module}/{id}/destroy', 'TrashController@destroy')->name('trash.destroy');

    Route::get('changelog', 'ChangelogController@index')->name('changelog');
    Route::get('documentation', 'DocumentationController@index')->name('documentation');

});
