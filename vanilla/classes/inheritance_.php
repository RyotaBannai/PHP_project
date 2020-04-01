<?php

// requireしたファイルのecho やvar_dumpを出力したくないが、
// それをデータとして保持したいときはこんな感じで.
ob_start();
require_once('myclass.php');
$contents = ob_get_clean();
# ob_get_clean() essentially executes both ob_get_contents() and ob_end_clean().
// ob_get_contents();
// ob_clean();

// var_dump($contents);



class Programmer extends Employee {
    public function work(){ // オーバーライド
        echo 'Programming, what?', PHP_EOL;
        parent::work();
    }
}

$pro = new Programmer('Ban', Employee::REGULAR);
echo $pro->work();

$myarray = array(1,2,3);
$array_obj = (object)$myarray;
var_dump($array_obj);
// 標準クラスでキャストした添字配列のキーは整数値から文字列にキャストされる