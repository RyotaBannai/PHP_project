<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; //DBファサード
use Redis; //Redisファサード // config/app.php にalias ある

class RedisController
{
    protected $table;
    protected $id;

    public function __construct()
    {
        $this->table = 'users';
    }

    public function set(){
        $this->id=1;
        // db からデータ取得
        $data = DB::table($this->table)->select('id', 'name','email')->where('id', $this->id)->first();

        // redis へ文字列として保存
        #Redis::command('SET', [$this->id, $data]);
        Redis::command('RPUSH', ['user', $data->name]);

        return view('redis.showresult', [
            'data'=> $data->name,
        ]);
    }
    public function zrange(){

    }

    public function get(){
        $this->id=1;
        // db からデータ取得
        # $data = json_encode(Redis::command('GET', [$this->id]));
        $data = Redis::command('LRANGE', ['user',0,-1]);
        $users = '';
        foreach($data as $d){
            $users .= json_encode($d).'/ ';
        }

        return view('redis.showresult', [
            'data'=> $users,
        ]);
    }

}
