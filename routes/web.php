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
Route::resource('profile', 'ProfileController');

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::resource('profile', 'ProfileController', ['only' => ['edit', 'update']]);

Route::post('/checkin', 'ProfileController@checkIn');

Route::post('/befriend', 'UserController@befriend');

Route::post('/acceptfriend', 'UserController@acceptFriendRequest');
Route::post('/denyfriend', 'UserController@denyFriendRequest');
Route::post('/unfriend', 'UserController@unfriend');

Route::get('/leaderboards', 'ProfileController@leaderboards')->name('leaderboards');

Route::get('/friends', 'UserController@indexFriends')->name('friends');


// Route::resource('profile', 'ProfileController', ['only' => ['edit', 'update']]);