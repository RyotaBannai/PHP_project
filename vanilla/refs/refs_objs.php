<?php
$a = new stdClass(); // $a にはオブジェクトを表すidを保持する値への参照を格納.
$b = $a;
$c =& $a; //　オブジェクトのid1を持つオブジェクトへの参照

/*
 * $c
 * ↓ refs
 * $a [id1] -→ stdClass object [id1] (new stdClass)
 *               ↑
 * $b [id1]------|
 * */
var_dump(spl_object_id($c)); // id is 1
var_dump(spl_object_hash($c));

$d = new stdClass();
var_dump(spl_object_id($d)); // id is 2

echo memory_get_usage(); // PHP に割り当てられたメモリの量を返す：メモリリークが起きるとこの結果が増加.
// https://qiita.com/crhg/items/44380ee625ef4613a9e5
// 循環参照を作成するには、インスタンスを２つ作成し双方に他方のインスタンスをプロパティとして保持すれば良い.

echo PHP_EOL;
var_dump(gc_enabled()); // 循環参照gcが有効になっているかどうか.