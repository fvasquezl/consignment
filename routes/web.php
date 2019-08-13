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

Route::get('/', function () {
    return redirect('/sales');
});


Route::get('/sales','SalesController@index')->name('sales.index')->middleware('auth');


Route::prefix('/admin')->namespace('Admin')->middleware('auth','role:mi')->group(function(){
    Route::resource('users','UsersController');
});



Auth::routes();
