<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastSuccess
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        protected ToastMessage $toastMessage,
    ) {}

    /**
     * Execute the action.
     */
    public function execute(string $message): void
    {
        $this->toastMessage->execute($message, 'success');
    }
}
