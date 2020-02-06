<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        return response()
        ->view('state.index', [
            //cookieを取得する場合は, requestオブジェクトのcookieメゾット.
            'msg' => request()->cookie('app_title'), 
        ])
        ->cookie('app_title', 'laravel', 60 * 24 * 30); //one month
        // name, value, valid duration( minutes), path, domain, allow only via https (true or false)
    }
    public function session(){
        request()->session()->put('series', '速修シリーズ'); //put session

        return response()
        ->view('state.index', [
            'msg' => 'セッション',
            'state' => request()->session()->all(), // get session
        ]);
    }
    public function form(){    
        return view('state.form'); 
    }
    public function success(){    
        return view('state.success', [
            'name'=> request()->name,
        ]);
    }
    public function check(Request $req){
        $name = $req->nameval;
        if(empty($name) || mb_strlen($name) > 10){
            //入力値に問題がある場合, redirect でフォームへ返す.
            // ただし、そのままリダイレクトしてしまうと, 入力値が消えてしまうので, フラッシュを使う.
            // withInput
            // またリダイレクト先でエラーを表示できるように, フラッシュにエラーメッセージを保存しておく.

            /*
            return redirect('state/form')
            ->withInput()
            ->with('alert', 'Name is reuiqred, or input less than 10 characters.');
            */

            /*
                元のformに戻したいだけなら, 
                redirectより, backの方がシンプル.
            */
            return back()
            ->withInput()
            ->with('alert', 'Name is reuiqred, or input less than 10 characters.');
        }else{
            return redirect()->action('StateController@success', [
                'name' => $name, 
            ]);
        }
    }
}
