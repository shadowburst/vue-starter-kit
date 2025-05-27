<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastError
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
    public function execute(?string $message = null): void
    {
        $this->toastMessage->execute($message ?? __('messages.error'), 'error');
    }
}
