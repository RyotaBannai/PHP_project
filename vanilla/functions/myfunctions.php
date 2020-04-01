<?php
function add($v1, $v2){
    $ans = $v1+$v2;
    return $ans;
}
$ans = add(1,2);
var_dump($ans);

// タイプヒンティング
// 指定したタイプを渡さないと実行エラーになる
function array_output(array $var){
    if(is_array($var)){
        foreach($var as $v){
            var_dump($v);
        }
    }
}
array_output(range(1,5));

$myarray=range(1,5);
//先頭の１要素を取得する
$myarray = array_shift($myarray);
var_dump($myarray);

// コールバック関数
/*
 * 関数名を表す文字列
 * 無名関数
 * クラスやクラスのインスタンスとメソッド名を持つ配列
 * クラスの静的メソッドを表す文字列
*/
$myarray2 = array(true, false, 10, 0.1);
$myarray2= array_map('strval',$myarray2);
var_dump($myarray2);

// 可変関数
function func_caller($fn_name){
    if(function_exists($fn_name)){
        // 文字列を識別子として、関数系の処理を適用できる。
        $fn_name(); // 可変関数として関数の呼び出し.
    }
}
function say_hi(){
    echo 'hi';
}
// これで呼べちゃう。すげーおもろい。
func_caller('say_hi');
// あれ可変変数使える
$my_desired_fn_name = 'say_hi';
$arg_name = 'my_desired_fn_name';
func_caller($$arg_name);