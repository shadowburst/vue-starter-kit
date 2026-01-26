<?php

namespace App\Models;

use App\Enums\Permission\PermissionName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * @mixin IdeHelperPermission
 */
class Permission extends SpatiePermission
{
    protected function displayName(): Attribute
    {
        return Attribute::get(
            fn (): string => PermissionName::tryFrom($this->name)?->label() ?? $this->name,
        );
    }
}
