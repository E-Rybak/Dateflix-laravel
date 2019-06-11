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

/**
 *  get routes
 */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', 'LikeController@index')->name('like.index');

Route::get('/index/likes', 'LikeController@likes')->name('likes');

Route::get('/user/blocks', 'BlockController@index')->name('blocks');

Route::get('/chat', 'ChatController@index')->name('chats');

Route::get('/chat/{id}', 'ChatController@show')->name('chat.show');

Route::get('/home', 'HomeController@index')->name('home');

/**
 * 	post routes
 */
Route::post('/like', 'LikeController@store')->name('like');

Route::post('/block', 'BlockController@store')->name('block.store');

Route::post('/chat', 'ChatController@store')->name('chat.store');


/**
 * 	delete routes
 */
Route::delete('/like', 'LikeController@destroy')->name('like.destroy');

Route::delete('/block', 'BlockController@destroy')->name('block.destroy');


/**
 *  auth routes
 */
Auth::routes();