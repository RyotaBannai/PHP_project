<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function getData()
    {
        // このメソッドを直接呼び出すと言うよりかは、
        // データをall() で全て取ってきて、そのデータに対してメソッドを使う. と言うこともできる.

        // foreachでは連想配列で添字を使用して各要素を呼び出している訳じゃなく、
        // 各インスタンスのプロパティを取得しているのである.

        return $this->id.':'.$this->name;
    }
}
