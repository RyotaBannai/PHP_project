<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', //  'datetime:Y-m-d' 日付のフォーマットも指定できる
        // 'options' => 'array', // options属性 がjson形式にシリアライズされている時に、取り出し時点で自動でarray型にキャスト
                                //options属性へ値をセットすると配列は保存のために自動的にJSONへシリアライズ
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getData(){
        return $this->name.': '.$this->email;
    }

    // accssor $this->first_name;
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
