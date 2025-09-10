<?php

namespace App\Enums\Permission;

use App\Traits\Enums\Labels;

enum PermissionName: string
{
    use Labels;

    case USERS = 'users';

    public function label(): string
    {
        return __("enums.permission.name.{$this->value}");
    }
}
