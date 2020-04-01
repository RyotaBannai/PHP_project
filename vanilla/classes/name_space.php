<?php
namespace Other;
require_once 'cake.php';
//use Food\Sweets; // use を使った場合、最後の被修飾名でインポートすることと等価.
use \Food\Sweets\Cake;

// use \Food\Sweets as Foods;
// $mycake = new Foods\Cake();

// namespaceを指定したときは「完全修飾名」で指定
// namespaceを指定しない＝グローバルな空間
$mycake = new Cake();

