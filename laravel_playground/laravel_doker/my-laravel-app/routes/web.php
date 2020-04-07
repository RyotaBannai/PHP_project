<?php

use Illuminate\Support\Facades\Route;

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
Route::prefix('redis')->group(function(){
    // regex もしあればwhereでヒットするurl
    Route::get('{anything?}', 'RedisController@set')->where('anything', 'set');
    // Route::match(['/','set'], ',', function(){}); のように書くこともできる.
    Route::get('get', 'RedisController@get');
});

Route::prefix('practice')->group(function(){
    Route::get('servicecontainer', 'ServiceContainerController@index');
});

#Route::get('redis/', 'SampleRedisController@set');
#Route::get('/redis', function () {
#    return view('welcome');
#});

Route::get('/testCache', function() {
    Cache::put('name', 'aaa',100);

    return Cache::get('name');
});
