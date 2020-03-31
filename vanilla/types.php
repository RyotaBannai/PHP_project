<?php
$int=011; // 8進数
$int2=0xff; // 16進数

echo $int, PHP_EOL;
echo $int2, PHP_EOL;

var_dump(PHP_INT_MAX);
var_dump(PHP_INT_MAX+1); //最大値を超えると自動的に浮動小数点数へキャストされる
var_dump(PHP_INT_SIZE);

// キャスト方法 int
$int3=intval("1");
$int4=(int)("1");
$int5=(integer)("1.2"); // 1になる
echo $int3,$int4,$int5,PHP_EOL;

// float
$f1=(float)("1.2");
$f2=(double)("1.2");
$f3=floatval("1.2");
echo $f1, $f2, $f3, PHP_EOL;

$mystr='$f1これは展開されない\n';
$mystr2="$f1 これはダブルクオートで初期化しているので、\n変数と特殊文字列が展開される\n";
$mystr3="${f1}半角スペース分開けたくない場合は、波かっこで囲む\n";
echo $mystr,PHP_EOL;
echo $mystr2;
echo $mystr3;

class NowDocTest{
    // プロパティの宣言
    const Doc2 = <<<EOI
PHP5.3からは
・変数を含まない場合
・ドル文字がエスケープされている場合
はconstに指定できる.
\$mystr こんな感じ.
EOI;
}
$ndt = new NowDocTest();
echo $ndt->Doc2;

// echo は自動的に文字列型へキャストする
// 明示的に小数点以下を出力した場合は,
// printfなどの「出力整形関数」を使う.
printf('%.1f', 15.0);
