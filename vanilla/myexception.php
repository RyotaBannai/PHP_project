<?php
namespace Playground;
use \Exception; // namespaceを使っているときはuseで用いるクラスを宣言しておくこと.

function div($v1, $v2){
    if ($v2 === 0){
        throw new Exception('you try to devide number by zero. EXCEPTION~~');
    }
    return $v1/ $v2;
}
try{
    echo div(1,2), PHP_EOL;
    echo div(2,0), PHP_EOL;
}catch (Exception $e){
    echo 'Exception!', PHP_EOL;
    echo $e->getMessage();
}