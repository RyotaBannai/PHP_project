<?php
// 無名関数. js やrubyと同じようなもの.
$add_one = function($v1, $v2){
    return $v1+$v2;
};
var_dump($add_one(1,2));


// htmlに出力するためにエスケープ処理を施す
$in_need_escaped = array(
    '"ダブルクオーテーション"',
    '\'シングルクオーテーション\'',
    '<tag>',
    '&ampersand',
    '< less than',
    '> more than'
);

// ENT_QUOTES	Will convert both double and single quotes.
// ENT_COMPAT	Will convert double-quotes and leave single-quotes alone.
// ENT_NOQUOTES	Will leave both double and single quotes unconverted.
$escaped = array_map(
    // 無名関数をコールバック関数として使うのは言語共通.
    function(string $item){return htmlspecialchars($item, ENT_QUOTES, 'utf-8');},
    $in_need_escaped);
var_dump($escaped);

// クロージャ (無名関数で定義された変数. 変数にはクロージャオブジェクトを格納.）)
$my_pow  = function ($times = 2){
    return function ($v) use (&$times){ // use() 構文を使って、関数内で用いる変数を指定.
        return pow($v, $times);
    };
};

$cube=$my_pow(3);
var_dump($cube(2)); // 2 の3乗

// php -m でmodule確認できる.
// どのような関数が定義されているか調べる. get_defined_functions()
// var_dump(get_defined_functions()); // internal と user の２つのキーを持つ連想配列.
var_dump(zend_version());

