<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class UserController extends Controller
{
    public function index(Request $req)
    {
        // $users = User::all();
        // $users = DB::table('users')->get(); // query builder
        $users = DB::table('users')->pluck('name'); // 単一カラムの値をコレクションで取得したい場合はpluck. (key, value) で二つ取得することもできる

        // SQL文を直接渡したい場合は、rawメソッドを使用
        $user_count = DB::table('users')->select(DB::raw('count(*) as user_count, status'))
            // ->selectRaw('')
            // ->whereRaw(), ->orWhereRaw('')
            // ->whereColumn('first', 'second') // where first and second columns are the same.
            // ->whereColumn('first', '>', 'second')

            ->where('status', '<>', 1)
            // ->where(function($q){ // more than two
            //          $q->where('a', 1)
            //            ->where('b', '<>', 1)
            // })

            // json column query by using -> notation. ->記法
            // ->where('preferences->dining->meal', 'salad')
            // ->get()

            ->groupBy('status')
            ->get();

        // when() 条件節を使う.$roleがtrueの場合のみクロージャを実行
        // 第３引数にもう一つのクロージャを渡すことで、false用の処理も実行できる
        $role = '1';
        $users_bool = DB::table('users')
            ->when($role, function($q) use($role){
                return $q->where('role_id', $role);
            } //, function($q) { // this is for the case of $role is false }
            )
            ->get();
        // 悲観的ロック
        // ->sharedLock()->get()
        // lockForUpdate()->get()
        return view(
            'user.index',
            ['users'=>$users]
        );
    }
}
