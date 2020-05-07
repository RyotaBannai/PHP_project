<?php
namespace App\Http\Controllers;

use DB; //DBファサード
use Redis; //Redisファサード
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RedisController
{
    protected $table;
    protected $id;

    public function __construct()
    {
        $this->table = 'users';
    }

    public function set(){
        $this->id=2;
        // db からデータ取得
        $data = DB::table($this->table)->select('id', 'name','email')->where('id', $this->id)->first();

        // redis へ文字列として保存
        # Redis::command('SET', [$this->id, $data]);
        Redis::command('RPUSH', ['user', $data->name]);

        return view('redis.showresult', [
            'data' => $data->name,
        ]);
    }
    public function zrange(){

    }

    public function get(){
        $this->id=1;
        // db からデータ取得
        # $data = json_encode(Redis::command('GET', [$this->id]));
        $data = Redis::command('LRANGE', ['user',0,-1]);

        // $users = '';
        // foreach($data as $d){ $users .= json_encode($d).'/ '; }
        $data = collect($data)->toJson();
        return view('redis.showresult', [
            'data' => $data,
        ]);
    }

    public function get2(){
        Cache::put('greet', 'good morning', 600);
        // Cache::store('file')->put('bar', 'baz', 600);
        return view('redis.showresult', [
            'data' => collect(Cache::get('greet'))->toJson(),
        ]);
    }
    public function tag(){
        $john = 'john';
        $anne = 'anne';
        $seconds = 500;
        Cache::tags(['people', 'artists'])->put('John', $john, $seconds);
        Cache::tags(['people', 'authors'])->put('Anne', $anne, $seconds);
        return view('redis.showresult', [
            'data' => collect(Cache::tags(['people', 'artists'])->get('John'))->toJson(),
        ]);
    }

}
