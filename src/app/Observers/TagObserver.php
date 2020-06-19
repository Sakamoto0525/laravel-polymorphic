<?php

namespace App\Observers;

use App\Tag;

class TagObserver
{
    public function saved(Tag $tag)
    {
        var_dump("こんにちは！savedだよ", $tag);
        \Log::debug("Hoge");
    }
}
