<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * Eloquentモデルと対応するポリシーをマップ
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Gate::guessPolicyNamesUsing

        //確かにRouteっぽい
        Gate::define('update-post', function($user, $post){
           return $user->id === $post->user_id;
        });
        Gate::define('update-post-by-friends', function($user, $post){
            return $user->id === $post->author_id
                ? Response::allow( 'you\'re a friends of the author, so you have a right to update.' )
                : Response::deny( 'sorry you don\'t right to update');
        });
        Gate::define('update-delete',
            'App\Policies\PostPolicy@delete');
    }
}
