<?php

namespace Amalikov\Taggy\Models;

use Illuminate\Database\Eloquent\Model;
use Amalikov\Taggy\Scopes\TagUsedScopesTrait;

class Tag extends Model
{
	protected $fillable = ['name', 'slug', 'count'];
    use TagUsedScopesTrait;
}
