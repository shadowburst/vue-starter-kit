<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastMessage
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        //
    ) {}

    /**
     * Execute the action.
     */
    public function execute(string $message, string $type = 'message'): void
    {
        session()->flash($type, $message);
    }
}
