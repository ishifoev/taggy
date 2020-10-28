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
    
    /**
     * Add tag
     */
    public function tag($tags)
    {
       $this->addTags($this->getWorkableTags($tags));
    }

     /**
      * Untag tags
      */
    public function untag($tags = null)
    {
          if($tags === null) {
              $this->removeAllTags();
              return;
          }

          $this->removeTags($this->getWorkableTags($tags));
    }

    /**
     * Remove all tags
     */
    private function removeAllTags()
    {
        $this->removeTags($this->tags);
    }

    /**
     *Remove tags 
     */
    private function removeTags(Collection $tags)
    {
       $this->tags()->detach($tags);

       foreach($tags->where('count', '>', 0) as $tag) {
           $tag->decrement('count');
       }
    }

    /**
     * We just need use add tags Collection
     */
    private function addTags(Collection $tags)
    {
       $sync = $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());
       
       foreach(array_get($sync, 'attached') as $attachedId) {
           $tags->where('id', $attachedId)->first()->increment('count');
       }
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