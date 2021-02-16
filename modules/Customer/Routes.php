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

Route::get('/customers/ajax',            'CustomerController@ajax')->name('customers.ajax');
Route::post('/customers/{id}/restore',   'CustomerController@restore')->middleware('can:customers.view')->name('customers.restore');
Route::resource('customers',             'CustomerController');