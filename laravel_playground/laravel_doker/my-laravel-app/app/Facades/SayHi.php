<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class SayHi extends Facade
{
    protected static function getFacadeAccessor()
    {
        // ここにservice providerでbindしたキーを返す.
        return 'sayhi';
    }
}
