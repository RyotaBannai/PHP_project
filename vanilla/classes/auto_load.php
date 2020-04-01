<?php
function __autoload($name){
    $filename = ucfirst($name).'.php';
    if (is_readable($filename)){
        require_once $filename;
    }
}
// クラスを読み込んでいなくてもautoloadがうまくやってくれる.
$obj = new Food();
$obj->show_foods();

// __autoload はグローバル関数でないといけないため、複数のファイルで使用できない
// spl_autoload_register() を使う.