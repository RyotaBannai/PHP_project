<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function param(int $id=1){
        //もしルートパラメータを任意にする場合は, 既定値を設定.
        return view('view.article', [
            'param'=> $id,
        ]);
    }
}
