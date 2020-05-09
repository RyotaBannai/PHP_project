<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function images()
    {
        return $this->morphMany(Image::class, 'target'); // 親はmorphの立場なのでmorph名を加えてポリモーフィックリレーションを作成

        // target_idが投稿id、target_typeの投稿モデルのクラス名（Post::class）となり、画像がどの投稿の添付であるかを判別
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
