<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class TestAuthController extends Controller
{
    public function index(Request $req){
        return view('test',[
            'user' =>  Auth::id(),
            // 'user' =>  $request->user(),
            // blade でauth()->user()もok
        ]);
    }
    public function updatePost(Request $req){

        // リクエストにnameが存在するか判定
        // $request->has('name'),
        // クエストにnameが存在しており、かつ空でない事を判定
        // $request->filled('name')

        if($req->filled('post_id')){
            throw new Exception();
        }
        // 現在認証中のユーザーを渡す必要はない
        // そのため、特定のユーザーがアクションを実行できる認可を持っているか確認するには、forUserを使う
        // AuthorizationExceptionを使えば、認可に失敗すればExceptionを返す
        // Gate::authorize('update-post', $post);

        if(Gate::allows('update-post', $req->post_id)){
            return 'you have a right to update anytime.';
        }

        $is_friend = Gate::forUser($req->friends_id)->inspect('update-post-by-friends', $req->post_id);
        if($req->filled('friends_id') && $is_friend->allowed()){
            return $is_friend->message();
        }
        else{
            return $is_friend->message();
        }
    }

}
