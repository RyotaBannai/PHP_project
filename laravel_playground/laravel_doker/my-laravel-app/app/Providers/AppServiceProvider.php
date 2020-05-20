<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;
use Gate;
use App\Http\Middleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // handle とterminate で同じインスタンスを使いたい
        $this->app->singleton(Middleware\CheckAge::class);
        $this->app->singleton(Middleware\CheckAccessCopy::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

//        DB::query()->macro('getOrFail', function ($columns = ['*']){
//            $models = $this->get($columns);
//
//            if (count($models)) {
//                return $models;
//            }
//
//            throw (new ModelNotFoundException)->setModel(get_class($this->model));
//        });

    }
}
