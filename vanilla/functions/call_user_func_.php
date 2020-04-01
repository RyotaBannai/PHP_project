<?php
function add($v1, $v2){
    $ans = $v1+$v2;
    return $ans;
}
class Math{
    public function sub($v1, $v2){
        return $v1 - $v2;
    }
    public static function add($v1, $v2){
        return $v1+$v2;
    }
}

// コールバック関数の指定に続いて、引数を指定.
call_user_func('add', 1,2);
// コールバック関数には、無名関数も指定できる
call_user_func(function ($v1, $v2) {return $v1+$v2;}, 1,2);

// static メソッドの場合、クラス名を文字列で指定できる.
call_user_func(array('Math', 'add'), 1,2);
// static メソッドの場合、クラス名::メソッド名　で指定できる.
call_user_func('Math::add', 1,2);
// インスタンス変数とメソッド名を指定する場合
$mymath = new Math();
call_user_func(array($mymath, 'sub'),1,2);

// call_user_func_array() では第二引数をarrayで指定する.
// 関数の実装を知らずに用いることができる.
$ans = call_user_func_array('add', array(1,2,3));
echo $ans, PHP_EOL;