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
    public function create(Usr $user){ // Modelメソッドは必要ない。どの様なユーザーを認可するかをAuthなどで判定

    }
}
