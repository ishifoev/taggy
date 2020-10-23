<?php

namespace Amalikov\Taggy;

use Amalikov\Taggy\Models\Tag;

trait TaggableTrait
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}