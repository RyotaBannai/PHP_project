<?php

namespace App\Http\Middleware;
use Closure;

class CheckAge
{
    public function handle($request, Closure $next, $role, $rank)
    {
        if($request->age <= 20 && $role !='author'){
        //  if (! $request->user()->hasRole($role))
            return redirect('/');
        }
        return $next($request);

        // After リクエスト処理
        /*
         * $response = $next($request);
         * アクションを実行…
         * return $response;
         */
    }

    // some proceudres after sending http response...
    // 終了処理ミドルウェア
    public function terminate($request, $response)
    {
        // セッションデーターの保存…
    }

}
