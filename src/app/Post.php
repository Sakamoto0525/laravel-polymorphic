<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable') // NN関係のtagsを取得
                    ->using('App\Taggable') // カスタム中間テーブルを指定
                    ->withPivot([ // ほしい中間テーブルのカラムを指定
                        'id',
                        'value'
                    ]);
    }
}
