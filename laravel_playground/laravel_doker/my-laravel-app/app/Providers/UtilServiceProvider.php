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

    protected $defer = true;

    public function register()
    {

        // $this->app はサービスコンテナ
        // 第一引数にキー名（util）、第二引数にクラス名（MyUtil）入れて紐付けして登録
        $this->app->bind('util', 'App\Services\MyUtil'); // 結合処理（バインド）はサービスプロバイダーに記述.
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // $defer = trueの際は必ず定義が必要
        // $this->app->deferredServicesプロパティにRiak\Connectionのインスタンス生成ルールは
        // App\Providers\RiakServiceProviderに定義されていることを保存
        return ['util'];
    }
}
