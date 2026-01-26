<?php

namespace App\Enums\Toast;

use App\Traits\Enums\Labels;

enum ToastType: string
{
    use Labels;

    case INFO = 'info';
    case SUCCESS = 'success';
    case WARNING = 'warning';
    case ERROR = 'error';

    public function label(): string
    {
        return __("enums.toast.type.{$this->value}");
    }
}
