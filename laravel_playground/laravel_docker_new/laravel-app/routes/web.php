<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::auth(['verify'=>true]);
// this makes the access to all paths authenticable
Route::middleware('verified')->group(function () {
    Route::group(['middleware'=>['web']], function(){
       Route::get('/home', 'HomeController@index');
       Route::get('/test', 'TestAuthController@index');
       Route::get('/showmail', function(){
           return new App\Mail\OrderShipped();
       });
    });
});
