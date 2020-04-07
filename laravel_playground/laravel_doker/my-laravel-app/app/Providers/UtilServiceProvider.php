<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UtilServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app はサービスコンテナ
        // 第一引数にキー名（util）、第二引数にクラス名（MyUtil）入れて紐付けして登録
        $this->app->singleton('util', 'App\Services\MyUtil'); // 結合処理（バインド）はサービスプロバイダーに記述.
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * bootメソッドはregisterメソッドによる初期処理が完了した後に実行される.
         * サービスコンテナで解決したインスタンスを利用した処理を記述できる.
         * イベントリスナー登録やルーティングなどの処理はこのメソッドで実装する.
         *
         * */
        //
    }
}
