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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home', 'Auth\LoginController@login');
Route::get('/inscription', 'Auth\RegisterController@showRegistrationForm')->name('inscription');
Route::post('/inscription', 'Auth\RegisterController@register');
Route::get('post/new', 'PostController@create')->name('post.new');
Route::get('post/list', 'PostController@list')->name('post.list');
Route::post('post/{post}', 'PostController@update');
Route::resource('post', 'PostController');
Auth::routes();