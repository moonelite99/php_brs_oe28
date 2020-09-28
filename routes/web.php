<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'localization'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

        Route::get('/', 'HomeController@admin_index')->name('admin_index');

        Route::resource('books', 'BookController');

        Route::resource('users', 'UserController');
    });

    Route::post('/lang', 'LangController@postLang')->name('switch_lang');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/books', 'BookController@show_all')->name('books');

    Route::get('/book/{book}', 'BookController@show')->name('show_book');
});
