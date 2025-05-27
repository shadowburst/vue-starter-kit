<?php

namespace App\Services;

use App\Actions\Toast\ToastError;
use App\Actions\Toast\ToastInfo;
use App\Actions\Toast\ToastMessage;
use App\Actions\Toast\ToastSuccess;
use App\Actions\Toast\ToastSuccessOrError;
use App\Actions\Toast\ToastWarning;
use App\Data\ToastMessagesData;
use Illuminate\Support\Facades\Session;

class ToastService
{
    public function __construct(
        public ToastError $error,
        public ToastInfo $info,
        public ToastMessage $message,
        public ToastSuccess $success,
        public ToastWarning $warning,
        public ToastSuccessOrError $successOrError,
    ) {}

    public function get(): ToastMessagesData
    {
        return ToastMessagesData::from([
            'info'    => Session::pull('info'),
            'success' => Session::pull('success'),
            'warning' => Session::pull('warning'),
            'error'   => Session::pull('error'),
        ]);
    }
}
