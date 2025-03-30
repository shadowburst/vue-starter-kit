<?php

namespace App\Services;

use App\Actions\Toast\ToastError;
use App\Actions\Toast\ToastInfo;
use App\Actions\Toast\ToastMessage;
use App\Actions\Toast\ToastSuccess;
use App\Actions\Toast\ToastWarning;
use App\Data\ToastMessagesData;

class ToastService
{
    public function __construct(
        public ToastError $error,
        public ToastInfo $info,
        public ToastMessage $message,
        public ToastSuccess $success,
        public ToastWarning $warning,
    ) {}

    public function get(): ToastMessagesData
    {
        return new ToastMessagesData(
            info: session('info'),
            success: session('success'),
            warning: session('warning'),
            error: session('error'),
        );
    }
}
