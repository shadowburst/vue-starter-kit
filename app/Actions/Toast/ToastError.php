<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastError
{
    use QueueableAction;

    public function __construct(
        protected ToastMessage $toastMessage,
    ) {}

    public function execute(?string $message = null): bool
    {
        return $this->toastMessage->execute($message ?? __('messages.error'), 'error');
    }
}
