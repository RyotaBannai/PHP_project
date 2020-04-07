<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; //DBファサード
use Redis; //Redisファサード // config/app.php にalias ある

class FacadeController
// ファサード： クラスメソッド の形式でサービス（クラス）を手軽るに利用できる機能
// なるべくロジックの記述を奥にしまいこんで、
// 簡潔にクラスのメソッドを呼び出すようにするのがファサードの役割
{
    protected $val;

    public function __construct()
    {
        $this->val = '';
    }

    public function index()
    {

    }
}
