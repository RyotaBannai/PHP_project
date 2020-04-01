<?php
// 引数に渡した変数の中身を書き換える可能性のある関数:「破壊的な関数」という. sort()なども破壊的な関数
function add_one(&$value){
    $value += 1;
}
$myitem = 10;
// 参照して計算しているためreturnしない.
add_one($myitem);
// add_one(2); // 値を直接渡せない
echo $myitem, PHP_EOL;

// 参照の返り値に参照を用いたい場合は、関数名の初めに&をつける
function &sub_one(&$value){
    $value -= 1;
    return $value; // 直接値を指定してはいけない.
}
$myitem2 = sub_one($myitem);
echo $myitem2, PHP_EOL;