<?php

namespace App\Support;

use App\Data\Toast\ToastData;
use App\Enums\Toast\ToastType;
use Inertia\Inertia;

class Toast
{
    private static function flash(ToastType $type, string $message): void
    {
        Inertia::flash('toast', new ToastData(
            type    : $type,
            message : $message,
            title   : __("enums.toast.type.{$type->value}"),
        ));
    }

    public static function info(string $message): void
    {
        static::flash(ToastType::INFO, $message);
    }

    public static function success(string $message): void
    {
        static::flash(ToastType::SUCCESS, $message);
    }

    public static function warning(string $message): void
    {
        static::flash(ToastType::WARNING, $message);
    }

    public static function error(string $message): void
    {
        static::flash(ToastType::ERROR, $message);
    }
}
