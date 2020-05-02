<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }
    public function post(User $user, Post $post){
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }
    public function create(User $user){

        // createのように、モデルインスタンスを受け取らないポリシーメソッドを定義する場合は、モデルインスタンスを受け取る必要は無い
        // Modelメソッドは必要ない。どのユーザーを認可するかをAuthで判定

    }
}
