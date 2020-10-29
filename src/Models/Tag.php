<?php

namespace Amalikov\Taggy\Models;

use Illuminate\Database\Eloquent\Model;
use Amalikov\Taggy\Scopes\TagUsedScopesTrait;

class Tag extends Model
{
    use TagUsedScopesTrait;
}
