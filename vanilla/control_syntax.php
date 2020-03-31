<?php
$display_message = TRUE;
?>
<?php if($display_message): ?>
<p>このメッセージは $display_message がTRUEのときにのみ表示されるメッセージです。</p>
<?php else: ?>
<p>このメッセージは $display_message がFALSEのときにのみ表示されるメッセージです。</p>
<?php endif; ?>

<?php
$array = array(1,2,3,4,5);
for ($i=0, $end=count($array); $i<$end; ++$i){
    echo $array[$i], ' ';
}

$dice = range(1,6);
shuffle($dice);
var_dump($dice);