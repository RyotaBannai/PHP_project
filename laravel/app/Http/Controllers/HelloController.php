<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*
	クライアントからの要求を受け取ると、まずはルーティング機能を利用して
	呼び出すべきコントローラー（アクション）を決定する.

	GET /hello -> routes.rb -> HelloController@index (呼び出されるアクション)
	ルーティング設定（ルート）は /routes/web.phpに定義.
*/
//Controllerクラスを継承.
class HelloController extends Controller
{
  //アクションメソッドを定義
   public function index(){
     //出力を戻り値に
     return 'Hi wassup!';
  }
}
