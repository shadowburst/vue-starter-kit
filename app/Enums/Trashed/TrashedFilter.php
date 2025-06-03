<?php

namespace App\Enums\Trashed;

use App\Traits\Enums\Labels;

enum TrashedFilter: string
{
    use Labels;

    case ONLY = 'only';
    case WITH = 'with';

    public function label(): string
    {
        return __("enums.trashed.filter.{$this->value}");
    }
}
