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

Route::get('/{any}', 'SinglePageController@index')->where('any', '.*');

Route::get('/', function () {
    return view('Welcome');
});

Route::get('/webapp', function () {
    return view('Webapp');
});

Route::get('/playlist', function () {
    return view('Playlist');
});

Route::post('/api/task', 'ApiController@storeTask');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');