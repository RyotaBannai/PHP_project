<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Models\Flight;

class ORMController extends Controller
{
    # protected $guard = ['price']; // blacklist
    # protected $fillable = []; // whitelist

    public function index(){
        $flights = Flight::all();
        return view(
            'flight.index',
            ['items'=> $flights]
        );
    }
    public function store(Flight $flight, Request $request){
        $flight->name = 'test';
        $flight->airline = 'Singapore airline';
        $flight->save(); // データベースへ挿入. created_at updated_at は自動的に設定.
        // updateしたい時もsave()を使う.
        // 複数のレコードをwhereで取得して更新したい時はupdate().
        $id = $flight->id; // idを取得

        // query builderを使う場合
//        $param = ["content" => "コンテンツ"];
//        DB::insert('insert into memos (content) values (:content)', $param);
//        $id = DB::getPdo()->lastInsertId();
        return view(
            'flight.store',
            ['result' => $id]
        );
    }
}
