<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

// プロバイダーで利用できるようになったサービスを利用
use App\Services\MyUtil; // サービス（Utilクラス）のエイリアスを作成

use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection ;

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


Route::get('/post', function () {
    // 名前付きルートを渡すと、それがurlになる
    // $url = URL::signedRoute('comment.show', ['user' => 1]); // 名前付きルートで渡す
    $tmpUrl = URL::temporarySignedRoute(
        'comment.show', now()->addMinutes(30), ['user' => 1]);
    return view("view.index", compact('url', 'tmpUrl'));
})->name('comment.index');

Route::get('/post/{user}/', 'RoutesController@sendAllParms')->name('comment.show');


Route::get('/sayhi','FacadeController@index');
Route::get('/dojobs', 'SameFunctionsController@index');
Route::get('/food', 'FoodController@index');


Route::get('/order', 'OrderController@order');
Route::post('/ordered', 'OrderController@ordered');

Route::prefix('users')->group(function(){
    Route::get('list', 'UserController@userList');
    Route::get('form', 'UserController@userForm')->name('user.form');
    Route::post('out', 'UserController@userOut')->name('user.out');
    Route::get('/', 'UserController@index');
    Route::get('name', 'UserController@name');
    Route::get('resource', function(){
        // return new UserCollection(User::all());
        return new UserCollection(User::all());
    });
});

Route::get('/logging','LogController@index');

Route::prefix('flight')->group(function (){
    Route::match(['get'], 'display', 'ORMController@index');
    Route::get('/register', 'ORMController@store');
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

Route::get('/user', 'RedisController@get')->middleware('checkAge:author, senior');

Route::get('/session', 'SessionController@index');
