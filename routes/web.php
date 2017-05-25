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

    Route::resource('users', 'UsersController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'users']]);
    Route::post('/users/editcurrent', 'UsersController@editcurrent')->name('user.editcurrent');
    Route::get('users/{id}/deactivate', 'UsersController@deactivate')->name('users.deactivate')->middleware('admins');
    Route::get('users/{id}/activate', 'UsersController@activate')->name('users.activate')->middleware('admins');
    Route::get('users/{id}/delete', 'UsersController@delete')->name('users.delete')->middleware('admins');
    Route::post('/users/addavatar', 'UsersController@addavatar')->name('user.addavatar');

    Route::resource('settings/redirects', 'RedirectsController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'redirects']]);
    Route::get('settings/redirects/{id}/deactivate', 'RedirectsController@deactivate')->name('redirects.deactivate')->middleware('developers');
    Route::get('settings/redirects/{id}/activate', 'RedirectsController@activate')->name('redirects.activate')->middleware('developers');
    Route::get('settings/redirects/{id}/delete', 'RedirectsController@delete')->name('redirects.delete')->middleware('developers');

    Route::resource('settings/translations', 'TranslationsController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'translations']]);
    Route::get('settings/translations/{id}/deactivate', 'TranslationsController@deactivate')->name('translations.deactivate')->middleware('developers');
    Route::get('settings/translations/{id}/activate', 'TranslationsController@activate')->name('translations.activate')->middleware('developers');
    Route::get('settings/translations/{id}/delete', 'TranslationsController@delete')->name('translations.delete')->middleware('developers');
    Route::get('settings/translations/locale/{locale}', 'TranslationsController@changelocale')->name('translations.changelocale');
    Route::post('settings/translation/duplicate', 'TranslationsController@duplicate')->name('translations.duplicate')->middleware('developers');

    Route::resource('settings/languages', 'LanguagesController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'languages']]);
    Route::get('settings/languages/{id}/deactivate', 'LanguagesController@deactivate')->name('languages.deactivate')->middleware('developers');
    Route::get('settings/languages/{id}/activate', 'LanguagesController@activate')->name('languages.activate')->middleware('developers');
    Route::get('settings/languages/{id}/delete', 'LanguagesController@delete')->name('languages.delete')->middleware('developers');

    Route::resource('settings/options', 'OptionsController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'options']]);
    Route::get('settings/options/{id}/delete', 'OptionsController@delete')->name('options.delete')->middleware('developers');
    Route::get('settings/options/locale/{locale}', 'OptionsController@changelocale')->name('options.changelocale');
    Route::post('settings/options/duplicate', 'OptionsController@duplicate')->name('options.duplicate')->middleware('developers');

    Route::get('trash', 'TrashController@index')->name('trash');
    Route::get('trash/{module}/{id}/revoke', 'TrashController@revoke')->name('trash.revoke')->middleware('developers');
    Route::get('trash/{module}/{id}/destroy', 'TrashController@destroy')->name('trash.destroy')->middleware('developers');

    Route::get('changelog', 'ChangelogController@index')->name('changelog');
    Route::get('documentation', 'DocumentationController@index')->name('documentation');

    Route::resource('forms/definitions', 'FormsController', ['except' => ['show', 'create', 'destroy'], 'names' => [
        'index' => 'forms.definition',
        'edit' => 'forms.definition.edit',
        'update' => 'forms.definition.update'
    ]]);
    Route::get('forms/definitions/{id}/deactivate', 'FormsController@deactivate')->name('forms.definition.deactivate')->middleware('developers');
    Route::get('forms/definitions/{id}/activate', 'FormsController@activate')->name('forms.definition.activate')->middleware('developers');
    Route::get('forms/definitions/{id}/delete', 'FormsController@delete')->name('forms.definition.delete')->middleware('developers');
    Route::get('forms/definitions/locale/{locale}', 'FormsController@changelocale')->name('forms.changelocale');
    Route::post('forms/definitions/duplicate', 'FormsController@duplicate')->name('forms.duplicate')->middleware('developers');

    Route::resource('forms/definitions/{id}/controls', 'ControlsController', ['except' => ['show', 'create', 'destroy'], 'names' => [
        'index' => 'forms.definition.controls',
        'edit' => 'forms.definition.control.edit',
        'update' => 'forms.definition.control.update'
    ]]);
    Route::get('forms/definitions/control/{id}/deactivate', 'ControlsController@deactivate')->name('forms.definition.control.deactivate')->middleware('developers');
    Route::get('forms/definitions/control/{id}/activate', 'ControlsController@activate')->name('forms.definition.control.activate')->middleware('developers');
    Route::get('forms/definitions/control/{id}/destroy', 'ControlsController@destroy')->name('forms.definition.control.destroy')->middleware('developers');

    Route::get('forms/sent', 'FormSentController@index')->name('forms.sent');
    Route::get('forms/sent/{id}', 'FormSentController@show')->name('forms.sent.form');

    Route::get('settings', function() {
        return redirect()->to('cmsbackend/settings/options');
    });

    Route::get('forms', function() {
        return redirect()->to('cmsbackend/forms/definitions');
    });


    Route::resource('pages', 'PagesController', ['except' => ['show', 'create', 'destroy'], 'names' => ['index' => 'pages']]);

    Route::get('pages/{id}/deactivate', 'PagesController@deactivate')->name('pages.deactivate');

    Route::get('pages/{id}/activate', 'PagesController@activate')->name('pages.activate');

    Route::get('pages/{id}/delete', 'PagesController@delete')->name('pages.delete')->middleware('developers');

    Route::get('pages/locale/{locale}', 'PagesController@changelocale')->name('pages.changelocale');

    Route::get('pages/{id}/gallery', 'PagesController@gallery')->name('pages.gallery');

    Route::get('pages/{id}/sections', 'PagesController@sections')->name('pages.sections');

    Route::get('pages/{id}/options', 'PageOptionsController@index')->name('pages.options');
    Route::post('pages/{id}/options', 'PageOptionsController@store')->middleware('developers');
    Route::get('pages/options/{id}', 'PageOptionsController@value')->name('pages.options.value');
    Route::put('pages/options/{id}', 'PageOptionsController@update_value');
    Route::get('pages/options/{id}/edit', 'PageOptionsController@edit')->name('pages.options.edit')->middleware('developers');
    Route::put('pages/options/{id}/edit', 'PageOptionsController@update')->middleware('developers');
    Route::get('pages/options/{id}/destroy', 'PageOptionsController@destroy')->name('pages.options.delete')->middleware('developers');

    Route::get('pages/{id}/advanced', 'PagesController@advanced')->name('pages.advanced')->middleware('developers');
    Route::put('pages/{id}/advanced', 'PagesController@update_advanced')->middleware('developers');

    Route::get('{model}/{model_id}/seo', 'SeoController@edit')->name('seo');
    Route::post('{model}/{model_id}/seo', 'SeoController@store');
    Route::put('{model}/{model_id}/seo', 'SeoController@update');

    Route::get('settings/modules', 'ModulesController@index')->name('index-modules');
    Route::post('settings/modules', 'ModulesController@store')->middleware('developers');
    Route::get('settings/modules/{id}/edit', 'ModulesController@edit')->middleware('developers')->name('edit-modules');
    Route::put('settings/modules/{id}/edit', 'ModulesController@update')->middleware('developers');
    Route::get('settings/modules/{id}/activate', 'ModulesController@activate')->middleware('developers')->name('activate-modules');
    Route::get('settings/modules/{id}/deactivate', 'ModulesController@deactivate')->middleware('developers')->name('deactivate-modules');
    Route::get('settings/modules/{id}/delete', 'ModulesController@delete')->middleware('developers')->name('delete-modules');

    Route::get('modules/{module_id}', 'ModuleRecordsController@index')->name('records');
    Route::post('modules/{module_id}', 'ModuleRecordsController@store');
    Route::get('modules/{module_id}/{record_id}/edit', 'ModuleRecordsController@edit')->name('records.edit');
    Route::put('modules/{module_id}/{record_id}/edit', 'ModuleRecordsController@update');
    Route::get('modules/{module_id}/{record_id}/activate', 'ModuleRecordsController@activate')->name('records.activate');
    Route::get('modules/{module_id}/{record_id}/deactivate', 'ModuleRecordsController@deactivate')->name('records.deactivate');
    Route::get('modules/{module_id}/{record_id}/destroy', 'ModuleRecordsController@destroy')->name('records.destroy');
    Route::get('modules/{module_id}/{locale}', 'ModulesController@changelocale')->name('records.changelocale');

});
