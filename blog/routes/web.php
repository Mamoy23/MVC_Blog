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

Route::group(['middleware' => 'checkStatus'], function() {

    Route::get('billet/new', 'PostController@create')->name('billet.new');
    Route::get('billet/list', 'PostController@list')->name('billet.list');
    Route::post('billet/{post}', 'PostController@update');
    Route::resource('billet', 'PostController');
    Route::resource('comment', 'CommentController');
    
    Route::get('admin', 'AdminController@index')->name('admin.index');
    Route::get('admin/users', 'AdminController@users')->name('admin.users');
    Route::get('admin/billets', 'AdminController@posts')->name('admin.posts');
    Route::get('admin/comments', 'AdminController@comments')->name('admin.comments');
    Route::post('admin/ban', 'AdminController@banUser')->name('admin.ban');
    Route::post('admin/deban', 'AdminController@debanUser')->name('admin.deban');
    Route::post('admin/role', 'AdminController@updateUserRole')->name('admin.role');
});

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/home', 'Auth\LoginController@login');
Route::get('/inscription', 'Auth\RegisterController@showRegistrationForm')->name('inscription');
Route::post('/inscription', 'Auth\RegisterController@register');
Auth::routes();