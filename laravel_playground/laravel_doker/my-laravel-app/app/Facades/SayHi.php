<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class SayHi extends Facade
{
    protected static function getFacadeAccessor()
    {
        // ここにservice provderでbindしたキーを返す.
        return 'sayhi';
    }
}
