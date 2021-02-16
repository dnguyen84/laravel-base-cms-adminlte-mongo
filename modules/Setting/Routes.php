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

Route::get('/settings/ajax',            'SettingController@ajax')->name('settings.ajax');
Route::post('/settings/{id}/restore',   'SettingController@restore')->middleware('can:setting.view')->name('settings.restore');
Route::resource('settings',             'SettingController');