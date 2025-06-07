<?php

namespace App\Actions\Toast;

use Illuminate\Support\Facades\Session;
use Spatie\QueueableAction\QueueableAction;

class ToastMessage
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(string $message, string $type): bool
    {
        Session::flash($type, $message);

        return true;
    }
}
