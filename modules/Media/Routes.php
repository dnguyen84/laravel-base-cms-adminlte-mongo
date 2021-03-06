<?php

/*
|--------------------------------------------------------------------------
| Web routes for media module
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
| @link(https://www.rapidtables.com/convert/number/decimal-to-hex.html)
|
*/

Route::get('media',                                     'MediaController@index')->name('media.index');

// Get last media has uploaded for current user
Route::get('media/uploaded',                            'MediaController@uploaded')->name('media.uploaded');

Route::post('media/upload',                             'MediaController@upload')->name('media.upload');
Route::post('media/update',                             'MediaController@update')->name('media.update');
Route::post('media/delete',                             'MediaController@delete')->name('media.delete');

