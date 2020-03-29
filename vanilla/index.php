<?php
// エラーが表示されるように設定。
// dev環境ならこれがデフォルト。
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
// ユーザーエラー
trigger_error('これはテストでエラーを出してます。', E_USER_WARNING);

$var = 'something awesome!';
echo $var, PHP_EOL;

$number = rand();
if($number %2 ==0) {
    echo $number, ' is even', PHP_EOL;
}elseif ($number%2==1){
    echo $number,' is odd', PHP_EOL;
}

// echoで理論値は表示されない。
// var_dumpを使うと良い
echo(False);
var_dump(False);

$myArray = [1,2,3];
// echo($myArray); // error
var_dump($myArray);

var_dump(isset($myArray));
$myNull=null;
var_dump(isset($myNull)); // False. use is_null() for true

// 可変変数すげえ // 変数を組み立てる時とかに便利
echo '可変変数', PHP_EOL;
$var =1;
$var_name = 'var';
var_dump($$var_name);

$foo =1;
function some_fn(){
    $foo=10;
    $baz=20;
}
some_fn();
echo $foo; //これは 上書きされずに表示される
// echo $baz; //これはエラー

// スーパーグローバル変数
var_dump($_GET);
echo $GLOBALS['var'], PHP_EOL;

// 定数定義
define('BOOK', 'Perfect PHP');
echo BOOK, PHP_EOL;
$book = 'BOOK';
echo constant($book), PHP_EOL;

// 定義済み定数の表示
// var_dump(get_defined_constants());

// マジック定数
var_dump(__FILE__); // shows path to this file
var_dump(__NAMESPACE__);

# python 流のコメント シェルスクリプトもそう
// Javascript 風なコメント C++ もそう
/* css 形式のコメント */
?>

PHP スクリプト終わり。