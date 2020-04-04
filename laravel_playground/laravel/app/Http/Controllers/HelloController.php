<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book; //モデルクラスをインポート

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
		return view('hello.index', [
			'msg'=> 'Hi wassup!',
			'html'=> '<i>HTMLエスケープの無効化{!!…!!}</i>',
			'verbatim'=> '<i>{{…}}の無効化</i>',
			'random'=> random_int(0,100),
			'emptystring'=> '',
			'null'=> null,
		]);
	}

	public function view(){

		//viewに渡す変数をview変数という. 連想配列として準備
		$data = [
			'records' => Book::all(),
		];
		//viewメゾットでview呼び出し.
		return view('subviews.list', $data);
		//hello.view -> /hello/view.blade.php が呼ばれる.
  }
}
