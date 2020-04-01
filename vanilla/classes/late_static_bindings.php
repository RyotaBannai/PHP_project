
<?php
class myParent{
    public function helloGateway(){
        static::hello(); // 遅延静的メソッド：selfではなくてstaticを用いる.
    }
    public static function hello(){
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}
class myChild extends myParent {
    // 遅延静的束縛を使う場合、オーバーライドも必須.
    public static function hello(){
        echo __CLASS__, ' hello!', PHP_EOL;
    }
}
$myinst = new myChild();
$myinst->helloGateway();
