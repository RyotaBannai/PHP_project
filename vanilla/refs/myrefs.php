<?php
$a=10;
$ref=& $a; // 参照代入演算子（=&）
$b=$a; // 代入演算子（=）

function showall(...$args){
    foreach($args as $item){
        echo $item, PHP_EOL;
    }
}
#showall($a, $ref, $b);
$ref=20; // $refには$aの持つ値10を格納する領域を指し示す変数、つまり$aの参照があるため.
#showall($a, $ref, $b);
$ref=& $b;
#showall($a, $ref, $b);
// $ferに新しい参照を代入した場合は、新しい参照先が格納される。つまりここで全て10にはならない!

####

function array_pass($array){ // 値渡し
    $array[0]*= 2;
    $array[1]*= 2;
}
function array_pass_ref(&$array){ // 参照渡し
    $array[0]*= 2;
    $array[1]*= 2;
}
$a = 10;
$b = 20;
$myarr = array($a, &$b);
$myarr2 = array($a, $b);
#array_pass($myarr);
#showall(...$myarr);

array_pass_ref($myarr2);
showall(...$myarr2); // $a, $b から$myarr2 へは値渡しなので、関数array_pass_refは引数を参照渡しで受け取るけど影響がない
showall($a, $b);
