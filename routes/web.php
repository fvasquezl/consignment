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
    return redirect('sales');
});


Route::get('dashboard','DashboardController@index')->name('dashboard.index');

Route::prefix('/admin')->namespace('Admin')->middleware('auth','role:mi')->group(function(){
    Route::resource('users','UsersController');
});

Route::namespace('Sales')
    ->middleware('auth')
    ->group(function(){
        Route::get('/sales','ProductsController@index')->name('sales.index');
        Route::get('/sales/products','ProductsController@products')->name('sales.products');
        Route::get('/sales/details','ProductsController@details')->name('sales.details');

        Route::get('/sales/sohnen','SohnenProductsController@index')->name('sohnen.index');
        Route::get('/sales/sohnen/details','SohnenProductsController@details')->name('sohnen.details');
});



Auth::routes();
