<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function images()
    {
        return $this->morphMany(Image::class, 'target');
    }
}
