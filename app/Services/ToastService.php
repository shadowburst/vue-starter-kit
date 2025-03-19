<?php

namespace App\Services;

use App\Actions\Toast\ToastError;
use App\Actions\Toast\ToastMessage;
use App\Actions\Toast\ToastSuccess;
use App\Actions\Toast\ToastWarning;

class ToastService
{
    public function __construct(
        public ToastError $error,
        public ToastMessage $message,
        public ToastSuccess $success,
        public ToastWarning $warning,
    ) {}
}
