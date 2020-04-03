<?php

function caller(callable $function, ...$args)
{
    return $function(...$args);
}

function ma_main_fn(string $myarg)
{
    return caller(
        // 可変長引数.
        function (...$args) use ($myarg) {
            echo $myarg;
            foreach ($args as $item) { //7.4 から...spread演算子使える.
                foreach ($item as $txt) {
                    echo $txt;
                }
            }
    }, array('cha cha dance', 'real genius'));
}

ma_main_fn('haha');