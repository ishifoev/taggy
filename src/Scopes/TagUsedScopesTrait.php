<?php

namespace Amalikov\Taggy\Scopes;

trait TagUsedScopesTrait
{
    /**
     * Scope count equal or greater
     */
    public function scopeUsedGte($query, $count)
    {
       return $query->where('count', '>=', $count);
    }


    /**
     * Scope count greater than 
     */
    public function scopeUsedGt($query, $count)
    {
       return $query->where('count', '>', $count);
    }

    /**
     * Scope count less than or equal
     */
    public function scopeUsedLte($query, $count)
    {
       return $query->where('count', '<=', $count);
    }

    /**
     * Scope count less than
     */
    public function scopeUsedLt($query, $count)
    {
       return $query->where('count', '<', $count);
    }
}