<?php
class Employee{
    private $values = array();
    public function __get($name){
        echo "you tried to get private property $name do' not.";
    }
    public function __toString()
    {
        //オブジェクトを文字列にキャストしようとしたときに呼ばれる.
        return 'This class is:'. __CLASS__;
    }
}
$me = new Employee();
echo $me, PHP_EOL;
echo $me->values;

// print_r
// var_export
// ver_dump // var_exportが見やすい