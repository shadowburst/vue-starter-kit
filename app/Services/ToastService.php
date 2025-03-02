<?php

namespace App\Services;

use App\Actions\Toast\ToastDanger;
use App\Actions\Toast\ToastMessage;
use App\Actions\Toast\ToastSuccess;
use App\Actions\Toast\ToastWarning;

class ToastService
{
    public function __construct(
        public ToastDanger $danger,
        public ToastMessage $message,
        public ToastSuccess $success,
        public ToastWarning $warning,
    ) {}
}
