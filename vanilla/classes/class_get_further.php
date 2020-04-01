<?php
abstract class Employee{
    // abstract で定義した関数はpublic, protected
    abstract protected function work();
}
class Programmer extends Employee{
    public function work(){
        echo 'I\'m working';
    }
}
$pro = new Programmer();
$pro->work();

// abstract クラスではスーパーabstractクラスで
// 定義したプロパティを実装しなくてもok
abstract class Human extends Employee{
    abstract public function talk();
}

class MyHuman extends Human{
    public function work(){
        echo 'work';
    }
    public function talk(){
        echo 'talk';
    }
}

// インターフェイス
interface Reader{
    public function read();
    // public function write(); // 今回の場合、実装先でエラー

    public function read_array(Iterator $array); //タイプヒンティング 引数がiterableオブジェクトじゃないとエラー
}
interface Writer{
    public function write($value);
}
class Configure implements Reader, Writer{
    // 一つのクラスに実装した複数のインターフェイスが
    // 同名のメソッドを持っているとエラーになる.
    public function read(){}
    public function read_array(Iterator $array)
    {
        // 「型演算子」を用いてもチェックできる.
        if ($array instanceof Iterator === false){
            throw new \http\Exception\InvalidArgumentException('Interface Error');
        }
    }

    public function write($value){
    }

}

//定義済みインターフェース iterator を実装.
class myIterator implements Iterator{
    private $position = 0;
    private $array = array();

    public function __construct(array $target)
    {
        var_dump(__METHOD__);
        $this->position = 0;
        $this->array = $target;
    }

    public function current()
    {
        var_dump(__METHOD__);
        return $this->array[$this->position];
    }

    public function next()
    {
        var_dump(__METHOD__);
        ++$this->position;
    }
    public function key()
    {
        var_dump(__METHOD__);
        return $this->position;
    }

    public function valid()
    {
        var_dump(__METHOD__);
        return isset($this->array[$this->position]);
    }
    public function rewind()
    {
        var_dump(__METHOD__);
        $this->position=0;
    }
}
$target = array(
    "first",
    "second",
    "third"
);
// 初めにrewindが呼ばれる.
// validが正しい間ループ実行.
$myarray = new myIterator($target);
foreach($myarray as $item){
    echo $item, PHP_EOL;
}