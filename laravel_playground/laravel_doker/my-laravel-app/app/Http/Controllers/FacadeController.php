<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; //DBファサード
use Redis; //Redisファサード // config/app.php にalias ある
use SayHi;


class FacadeController
{
    protected $val;

    public function __construct()
    {
        $this->val = '';
    }

    public function index()
    {
        return SayHi::SayHi(); // ここで自分で作成したファサードを使用.
    }
}
