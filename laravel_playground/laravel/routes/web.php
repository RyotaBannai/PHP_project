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

Route::get('hello/', 'HelloController@index');
Route::get('hello/view', 'HelloController@view');

//名前空間付きのコントローラーの場合.
Route::namespace('Main')->group(function(){ 
	//route group.
	Route::prefix('view')->group(function(){
  	Route::get('master', 'ViewController@master');
  	Route::get('comp', 'ViewController@comp');
	});
});

//ルートパラメーターを渡す.
//もしルートパラメーターが予め想定できる値であれば、正規表現をwhereで宣言.
Route::get('route/{id?}', 'RouteController@param')->where(['id' => '[0-9]{2,3}']);

//可変長パラメータ
//Route::get('route/{keywd?}', 'RouteController@param')->where(['keywd'=>'.*']);

//もし, アクション（controllerなどの第二引数）を省略したい場合, web.php内でviewを返してしまうこともできる.
Route::view('/noaction', 'view.noaction', ['msg'=>'this route has no action jfyr.']);

//リダイレクト
Route::redirect('/home', '/');
// Route::redirect('home','/', 301); //恒久的なページのときは301 instead of 一時的にnot found no 302 as default.

//CRUDのroute処理を完結に行う, resource methods
Route::resource('articles', 'ArticleController');
//->excxept(['edit], 'update'); //exceptで使用しないメソッドを消去.

//fallback root
Route::fallback(function(){
	return view('view.error');
});