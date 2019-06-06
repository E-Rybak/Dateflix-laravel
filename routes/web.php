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
    return view('welcome');
});

Route::get('/index', 'LikeController@index')->name('like.index');

Route::get('/index/likes', 'LikeController@likes')->name('likes');

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/like', 'LikeController@store')->name('like');

Route::delete('/like', 'LikeController@destroy')->name('like.destroy');


Auth::routes();