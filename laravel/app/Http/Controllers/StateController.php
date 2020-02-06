<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        return response()
        ->view('state.index', [
            //cookieを取得する場合は, requestオブジェクトのcookieプロパティにアクセス.
            'App_title' => request()->cookie('app_title'), 
        ])
        ->cookie('app_title', 'laravel', 60 * 24 * 30); //one month
        // name, value, valid duration( minutes), path, domain, allow only via https (true or false)
    }
}
