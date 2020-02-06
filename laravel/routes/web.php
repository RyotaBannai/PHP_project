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

Route::prefix('ctrl')->group(function(){
    Route::get('/', 'CtrlController@index');
    Route::any('/form', 'CtrlController@form');
    Route::get('/header', 'CtrlController@header');
    Route::get('/outJson', 'CtrlController@outJson');
    Route::get('/outCSV', 'CtrlController@outCSV');
    Route::get('/plain', 'CtrlController@plain');
    Route::get('/redirectBasic', 'CtrlController@redirectBasic');
});