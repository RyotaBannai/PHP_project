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

//middlewareを使用する場合, 初めにuseで呼び出す.
use App\Http\Middleware\LogMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('ctrl')->group(function(){
    
    // group middlewareを定義.
    Route::get('/', 'CtrlController@index');
        Route::group(['middleware'=>['debug']], function(){Route::any('/form', 'CtrlController@form');
    });
    //->middleware(LogMiddleware::class);
    
    // 複数のmiddleware登録したい場合はコンマで区切る.
    // ->middleware(LogMiddleware::class, MergeViewsvalsMiddleware::class);

    Route::get('/header', 'CtrlController@header');
    Route::get('/outJson', 'CtrlController@outJson');
    Route::get('/outCSV', 'CtrlController@outCSV');
    Route::get('/plain', 'CtrlController@plain');
    Route::get('/redirectBasic', 'CtrlController@redirectBasic');
});