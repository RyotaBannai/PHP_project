<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

// プロバイダーで利用できるようになったサービスを利用
use App\Services\MyUtil; // サービス（Utilクラス）のエイリアスを作成

//use Storage;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection ;

// Use the method registered in service provider
$encrypt = app()->make('encrypter');

Route::any('/', function () {
    return view('welcome');
});

Route::get('/gate', 'TestGateController@index');

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

Route::prefix('file')->group(function() {
    Route::get('/', 'FileController@index');
    Route::post('upload', 'FileController@upload');
    Route::get('show', 'FileController@show');
    Route::get('info', function () {
        return '<pre>' . collect([
                asset('storage/file.txt'),
                public_path('storage'),
                storage_path('app/public'),
                Storage::url('file.jpg'),
            ])->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</pre>';
    });
});

//Route::get('users/{user}', function(User $user){
//    return $user;
//});

Route::prefix('users')->group(function(){
    Route::get('list', 'UserController@userList');
    Route::get('form', 'UserController@userForm')->name('user.form');
    Route::get('out', 'UserController@userOut')->name('user.out');
    Route::get('/', 'UserController@index');
    Route::get('name', 'UserController@name');
    //
    // Route::get('{user}', ['as' => 'copy.user', 'uses' => 'UserController@mdw'])->middleware('checkAccessCopy');
    Route::post('{user}', 'UserController@executeDupe');
    Route::get('{user}/show', 'UserController@show');
    Route::get('{user}/dupe', 'UserController@dupe');
    //
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
    Route::get('get', 'RedisController@get2');
    Route::get('tag', 'RedisController@tag');
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

Route::prefix('_post')->group(function() {
    Route::get('comment', 'PostController@comment');
    Route::get('show', 'PostController@show');
    Route::get('attach_tag', 'PostController@attachTag');
});
