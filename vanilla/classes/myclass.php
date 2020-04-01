<?php
class Employee{
    // クラス定数
    const PARTTIME = 0x01;
    const REGULAR = 0x02;
    const CONTRACT = 0x04;

    public static $age = 19;
    public $name;
    public $type;
    public $state = 'work';

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function work()
    {
        // this はインスタンスオブジェクとが自分自身を参照するためのキーワード
        echo 'I\'m '.$this->state.'ing.', PHP_EOL;
    }

    public function refurn_static_val(){
        // self はクラス自体参照するためのものキーワード
        return self::$age;
    }
    // クラスコンテキストから、自分自身を返せる.
    public static function give_u_myself(){
        return new self('anonymous', self::REGULAR);
    }

    public function return_myself(){
        return $this;
    }
}

$myemployee = new Employee('Bannai', Employee::REGULAR);
// 変数にはクラスへの「参照」が渡される
$ban = $myemployee;
$ban->work(); // メソッドの呼び出しには「アロー演算子」

// オブジェクトを複製したい場合は cloneを使う.
$ban2 = clone $myemployee;
$ban2->work();


echo $ban2->state, PHP_EOL;

// PHPでは後からプロパティを追加できる.
$ban2->title = 'Programmer';
echo $ban2->title, PHP_EOL;

// PHPではインスタンスオブジェクトもstaticにアクセスできる.
// Pythonではクラスのみで使える.
echo $ban2::$age, PHP_EOL;
echo Employee::$age, PHP_EOL;
echo $ban2->refurn_static_val(), PHP_EOL;

// クラスから直接使うときはダブルコロン :: にして、
// 呼び出すプロペティは必ずstaticにする.
$gotu = Employee::give_u_myself();
echo $gotu::$age, ' ',$gotu->name, PHP_EOL;

// クラス定数にアクセス
echo Employee::REGULAR, PHP_EOL;

// $thisで自分を返して、tyescriptみたいなメソッドチェーンみたいなのもできる.
var_dump($myemployee->return_myself()->return_myself()->return_myself());
