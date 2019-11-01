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

Route::get('/signin' , 'ImapController@signin');
Route::get('/send'   , 'ImapController@send');
Route::get('/email'  , 'ImapController@email');


Route::get('ajaxRequest', 'ImapController@ajaxRequest');
Route::post('ajaxRequest', 'ImapController@ajaxRequestPost');