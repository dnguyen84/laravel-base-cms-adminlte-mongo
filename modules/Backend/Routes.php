<?php

/*
|--------------------------------------------------------------------------
| Web routes for backend module
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => config('backend.route'), 'middleware' => ['can:backend.view']], function() {
    # Dashboard route
    Route::get('/',                         'Dashboard\IndexController@index')->name('admin.index');

    # Datatable ajax
    Route::get('/users/ajax',               'User\UserController@ajax')->name('users.ajax');
    Route::get('/users/search',             'User\UserController@search')->name('users.search');
    Route::any('/users/{user}/password',    'User\UserController@password')->middleware('can:user.password')->name('users.password');

    # Resource routes
    Route::resource('users',                'User\UserController');
    Route::resource('roles',                'Role\RoleController');
    Route::resource('perms',                'Perm\PermController');
});
