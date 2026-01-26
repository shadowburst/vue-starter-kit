<?php

namespace App\Models;

use App\Enums\Role\RoleName;
use App\Traits\Models\BelongsToTeam;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * @mixin IdeHelperRole
 */
class Role extends SpatieRole
{
    use BelongsToTeam;

    protected function displayName(): Attribute
    {
        return Attribute::get(
            fn (): string => RoleName::tryFrom($this->name)?->label() ?? $this->name,
        );
    }
}
