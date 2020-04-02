<?php
namespace Playground;
use \Exception; // namespaceを使っているときはuseで用いるクラスを宣言しておくこと.

//例外の拡張.
class ZeroDividionException extends Exception{}

####
$myexception = new ZeroDividionException();
// var_dump(get_object_vars($myexception)); // 変数はなし
var_dump(get_class_methods($myexception)); // getMessage, getCode, getTrace など
####


function div($v1, $v2){
    if ($v2 === 0){
        throw new ZeroDividionException('you try to devide number by zero. EXCEPTION~~');
    }
    return $v1/ $v2;
}
try
{
    echo div(1,2), PHP_EOL;
    echo div(2,0), PHP_EOL;
}
catch (ZeroDividionException $e)
{
    echo 'Zero Division Exception!', PHP_EOL;
    echo $e->getMessage();
    echo PHP_EOL;
    var_dump($e->getLine());
    echo PHP_EOL;
    var_dump($e->getTraceAsString()); // これは使える
}
catch (Exception $e){
    echo 'Exception!', PHP_EOL;
    echo $e->getMessage();
}