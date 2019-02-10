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

Route::namespace('Frontend')->group(function() {
    Route::get('/', 'HomeController@index');
    
    Route::get('showpost/{slug}', 'HomeController@showpost')->name('showpost');
    Route::get('showcategory/{slug}', 'HomeController@showcategory')->name('showcategory');
});


Route::name('backend.')->namespace('Backend')->group(function() {
    
    Route::get('login', 'UserController@index')->name('login');
    Route::post('login', 'UserController@login')->name('login');
    Route::get('logout', 'UserController@logout')->name('logout');
    
    Route::get('admin', 'HomeController@index')->name('home');
    Route::resource('category', 'CategoryController');
});
