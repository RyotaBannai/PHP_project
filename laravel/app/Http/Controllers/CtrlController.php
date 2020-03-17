<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtrlController extends Controller
{   
	public function __construct(){
		//クラス内でmiddlewareを定義.
		$this->middleware(function($request, $next){
			return $next($request);
		});
		// })->only(['basic', 'form']); 
		// only: 適用したいアクションのみ. <-> except
	}
    //Request : クライアントから送信された情報にアクセスするための手段.
    /*引数として渡すか, request()で直接使う.
    */
    public function index(Request $req){ //メソッドインジェクション
    // public function index(Request $req, $id) 
    // Request オブジェクトとルートパラメータを使いたい場合.
    //=> Request オブジェとの後方にルートパラメータを追加.

        return 'リクエストパス: '.$req->path();
    }
    /*
    public function index(){
        return 'リクエストパス: '.request()->path();
    }
    */

    public function plain(){
        return response('Hello', 200)->header('Content-Type', 'text/plain');
        //response architect text, status, headers
    }

    public function header(){
        return response()
        ->view('ctrl.header', ['msg'=>'view + header!'], 200)
        ->header('Content-Type', 'text/xml');
        //response architect text, status, headers

        /*複数のheaderを返したいときは, withHeaders([
            'Content-Type', 'text/xml',
            ...
        ])*/
    }
    public function outJson(){
        return response()
        ->json([
            'name'=>'Yoshihiro, YAMADA',
            'sex'=>'male',
            'age'=>18,
        ]);
        //->withCallback('callback'); // for json-p
    }
    
    //ファイルをダウンロードする.
    public function outCSV(){
        
        return response()
        /*
        ->download('directory', 'downloard,csv', 
        ['content-type'=>'text/csv']);

        //指定されたファイルをそのままスクリーンに表示する.
        ->file('directory', ['content-type'=>'image/png']); 
        */
        ->streamDownLoad(function(){
            print(
                "1,2019/10/1,123\n".
                "2,2019/10/2,116\n".
                "3,2019/10/3.98\n"
            );
        }, 'download.csv', ['content-type'=>'text/csv']);
    }

    public function redirectBasic(){
        //return redirect('ctrl.outJson'); // path name
        return redirect()->route('outJson'); // route name

        //return redirect()->route('outJson', ['id'=>10]); // route name with param

        //return redirect()->action('CtrlController@outJson', ['id'=>10]);

        //return redirect()->away('other web page url');
    }

    public function form(){
      return view('ctrl.form', [
        //'result'=>request()->nameval, 
                /* 
                 入力フォームに応じてRequestオブジェクトに「動的に付与されるプロパティ」のことを 
                「動的プロパティ」という.
                */

				//もし既定値を設定したい場合は, inputを使用.
				//既定値とカラ要素送信は別.
				'result' => request()->input('nameval', 'visitor')
        ]);
    }
}
