<?php

use Illuminate\Support\Facades\Route;

// プロバイダーで利用できるようになったサービスを利用
use App\Services\MyUtil; // サービス（Utilクラス）のエイリアスを作成

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

$encrypt = app()->make('encrypter');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/util', function(MyUtil $util){ // 無名関数でサービスの呼び出し
    #return $util->getMessage(); // サービスのメソッドをコール
    return app()->make('util')->getMessage();// コンテナがインスタンスを作成
    # return app('util')->getMessage(); // これでもok
    # app()->call( 'MyController@show' ); //static メソッドのように呼び脱すこともできる.
    # app()->call( 'MyController@show', ['id'=> $id] ); // 引数で渡したい場合
});

Route::get('/sayhi','FacadeController@index');
Route::get('/dojobs', 'SameFunctionsController@index');
Route::get('/food', 'FoodController@index');

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
