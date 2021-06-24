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

Route::get('/', 'PostController@index');

Auth::routes();

Route::get('/chat', 'HomeController@index')->name('home');

Route::get('/contacts','ContactsController@get');
Route::get('/conversation/{id}','ContactsController@getMessagesFor');
Route::post('/conversation/send','ContactsController@send');


Route::post('/','PostController@store');
Route::get('/post/{id}','PostController@show');
Route::get('/post/{id}/edit','PostController@edit');
Route::put('/post/{id}','PostController@update');
Route::delete('/post/{id}/delete','PostController@destroy');


Route::get('/profile/{id}/','PostController@profile');
Route::get('/profile/{id}/update','ContactsController@getProfile');
Route::put('/profile/update','ContactsController@updateProfile');
Route::get('/profile/{id}/','PostController@profile');

Route::post('/post/{id}/act', 'PostController@actOnChirp');



Route::post('/post/{id}','CommentController@store');
Route::delete('/post/{postId}/comment/{id}','CommentController@destroy');

Route::post('/profile/{id1}/friend','FriendController@store');
Route::get('/friends','FriendController@index');
Route::put('/friends/{id}/update','FriendController@update');
Route::delete('/friends/{id}/delete','FriendController@destroy');

