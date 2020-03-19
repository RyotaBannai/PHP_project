<?php

namespace App\Http\Middleware;

use Closure;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    // public function handle($request, Closure $next)
    // {
    //     /*ビュー変数の追加.
    //         $request->merge([
    //             'title'=>'速習Laravel',
    //             'author'=>'YAMADA,Yoshihiro'
    //             ]);
    //      */
    //     file_put_contents('/Users/ryota/Documents/access.log',date('Y-m-d H:i:s')."\n", FILE_APPEND);

    //     //次のミドルウェアの伸びだし.
    //     return $next($request); //クロージャー
    // }

    /*
        アクションメゾットの処理後に, middlewareから処理を加えたいとき.
    */
    public function handle($request, Closure $next)
    {
        file_put_contents('/Users/ryota/Documents/access.log', date('Y-m-d H:i:s')."\n", FILE_APPEND);

        $response = $next($request);

        $response->setContent(mb_strtoupper($response->content()));
        return $response; 
    }
}