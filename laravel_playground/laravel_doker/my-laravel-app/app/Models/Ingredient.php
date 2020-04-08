<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function getData()
    {
        // このメソッドを直接呼び出すと言うよりかは、
        // データをall() で全て取ってきて、そのデータに対してメソッドを使う. と言うこともできる.
        return $this->id.':'.$this->name;
    }
}
