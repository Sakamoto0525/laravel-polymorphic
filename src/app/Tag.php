<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * このタグをつけた全ポストの取得
     */
    public function posts()
    {
        return $this->morphedByMany('App\Post', 'taggable')
                    ->using('App\Taggable')
                    ->withPivot([
                        'id',
                        'value'
                    ]);
    }

    /**
     * このタグをつけた全ビデオの取得
     */
    public function videos()
    {
        return $this->morphedByMany('App\Video', 'taggable')
                    ->using('App\Taggable')
                    ->withPivot([
                        'id',
                        'value'
                    ]);
                }
}
