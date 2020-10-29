<?php

namespace Amalikov\Taggy\Scopes;

trait TaggableScopesTrait
{
      /**
     * Scope With Any Tag
     */
    public function scopeWithAnyTag($query, array $tags)
    {
        return $query->hasTags($tags);
    }

    /**
     * Scope With All Tag
     */
    public function scopeWithAllTags($query, array $tags)
    {
        foreach($tags as $tag) {
            $query->hasTags([$tag]);
        }
        return $query;
    }

    /**
     * Scope Has Tags
     */
    public function scopeHasTags($query, array $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            return $query->whereIn('slug', $tags);
        });
    }
}