<?php
$fruits = array('banana','apple','orange');
echo $fruits[0], PHP_EOL;

// これで新しい要素を追加できる.
$fruits[] = 'grape';
var_dump($fruits);

$init =1;
#$init[] = 'new value'; // すでに他のスカラー値で初期化しているので、配列に要素を追加できない
var_dump($init);

$myhash = array(
    'first'=>1,
    'second'=>2,
    'third'=>3,
    );
var_dump($myhash);
echo $myhash['first'], PHP_EOL;

$myhash1 = array(
    'first'=>1,
    'second'=>2,
    'third'=>3,
    );
$myhash2 = array(
    'first'=>4,
    'second'=>5,
    'third'=>6,
);
var_dump($myhash1+$myhash2); //上書きしない
var_dump(array_merge($myhash1,$myhash2)); //上書きする

$myarr1 =array('haha','hello','hi');
$myarr2 =array('whatup','yo','howru');
var_dump($myarr1+$myarr2); //上書きされない
var_dump(array_merge($myarr1+$myarr2)); //上書きされない


// ハッシュに特定のキーが存在するかどうか調べる.
// isset の方が早いが、値がnullの場合はfalseになってしまうので注意.
var_dump(array_key_exists('first',$myhash1));
var_dump(isset($myhash1['first']));
