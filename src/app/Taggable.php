<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Taggable extends MorphPivot
{
	protected $table = 'taggables';

    public function post()
    {
        return $this->belongsTo('App\Post', '');
    }
}
