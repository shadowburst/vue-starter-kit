<?php

namespace App\Enums\Role;

use App\Traits\Enums\Labels;

enum RoleName: string
{
    use Labels;

    case TESTER = 'tester';
    case OWNER = 'owner';
    case MEMBER = 'member';

    case EDITOR = 'editor';

    public function label(): string
    {
        return __("enums.role.name.{$this->value}");
    }
}
