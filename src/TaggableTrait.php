<?php

namespace Amalikov\Taggy;

use Amalikov\Taggy\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait TaggableTrait
{
    /**
     * Polymorphic relationship tags
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function tag($tags)
    {
       $this->addTags($this->getWorkableTags($tags));
    }

      public static function makeTagArray($tagNames)
    {
        if(is_array($tagNames) && count($tagNames) == 1) {
            $tagNames = reset($tagNames);
        }

        if(is_string($tagNames)) {
            $tagNames = explode(',', $tagNames);
        } elseif(!is_array($tagNames)) {
            $tagNames = array(null);
        }

        $tagNames = array_map('trim', $tagNames);

        return array_values($tagNames);
    }


    /**
     * We just need use add tags Collection
     */
    private function addTags(Collection $tags)
    {
       $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());
    }

    private function getWorkableTags($tags)
    {
        /**
         * Check tags in array we passing slugs tags
         */
        if(is_array($tags)){
            return $this->getTagModels($tags);
        }

        /**
         * check if tags is Model
         */
        if($tags instanceof Model) {
            return $this->getTagModels([$tags->slug]);
        }

        return $this->filterTagCollection($tags);
    }

     /**
     * Filter Tag Collection
     */
    private function filterTagCollection(Collection $tags)
    {
       return $tags->filter(function($tag) {
          return $tag instanceof Model;
       });
    }

    /**
     * Return Collection of tags
     */
    private function getTagModels(array $tags)
    {
       return Tag::whereIn('slug', $this->normaliseTagNames($tags))->get();
    }

   

    /**
     * Normalise Tag Names
     */
    private function normaliseTagNames(array $tags)
    {
         return array_map(function ($tag) {
            return str_slug($tag);
         }, $tags);
    }
}