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
    Route::get('/home', 'HomeController@index');
    
    Route::get('post/{slug}', 'HomeController@showpost')->name('post');
    Route::get('category/{slug}', 'HomeController@showcategory')->name('category');
    Route::get('page/{slug}', 'HomeController@showpage')->name('page');
    Route::get('tag/{name}', 'HomeController@showtag')->name('tag');
    Route::get('aseries/{sslug}/{catslug?}/{pslug?}', 'HomeController@showseries')->name('aseries');
    Route::get('contact', 'HomeController@contact')->name('contact');
    Route::get('pdf/{type}/{slug}', 'HomeController@generatepdf')->name('pdf');
    
    Route::get('error', function() {
        return view('frontend.error');
    })->name('frontend.error');
});


Route::name('backend.')->namespace('Backend')->group(function() {
    
    Route::get('login', 'UserController@index')->name('login');
    Route::post('login', 'UserController@login')->name('login');
    Route::get('logout', 'UserController@logout')->name('logout');
    
    Route::get('admin', 'HomeController@index')->name('home');
    Route::resource('categories', 'CategoryController');
    Route::resource('tags', 'TagController');
    Route::resource('posts', 'PostController');
    Route::resource('pages', 'PageController');
    Route::resource('menus', 'MenuController');
    Route::resource('series', 'SeriesController');
    Route::resource('extrafile', 'ExtraFileController');
    
    Route::post('storefile', 'PostController@storefile')->name('storefile');
    Route::post('deletefile', 'PostController@deletefile')->name('deletefile');
    Route::post('getMenyTypes', 'MenuController@getMenyTypes')->name('getMenyTypes');
    Route::get('serieslist/{id}', 'SeriesController@getSeriesList')->name('serieslist');
    
    
    Route::post('postedit', 'SeriesController@editpostorder')->name('postedit');
    Route::post('categoryedit', 'SeriesController@editcategororder')->name('categoryedit');
    Route::post('categoryadd', 'SeriesController@addCategorySeries')->name('categoryadd');
    Route::delete('deletecategoryseries/{id}', 'SeriesController@deletecategoryseries')->name('deletecategoryseries');
});
