<?php
//大小の区別なし
$b1=true;
$b2=TRUE;
$b3=True;

// echoで表示すると、文字列へ変換されるので
// 1と表示される
echo $b1, $b2, $b3, PHP_EOL;
var_dump($b1);

$b4=(boolean)1;
$b5=(boolean)0;
// booleandでキャストするとできる
var_dump($b4);
var_dump($b5);

$myxml = <<<XML
<?xml version='1.0' standalone='yes'?>
<movies>
<plot>
something special.
</plot>
</movies>
XML;

$movie = new SimpleXMLElement($myxml);
if ($movie[0]->plot){
    echo "this is true", PHP_EOL;
    echo $movie[0]->plot, PHP_EOL;
    var_dump($movie->xpath('//movies'));
    var_dump((boolean)$myxml);
}
else{
    echo'this is not true ';
    var_dump((boolean)$myxml);
}

// null, 0, カラである物がfalseに相当。
// '0'もfalseになる点に注意.
