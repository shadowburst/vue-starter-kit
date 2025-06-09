<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastSuccess
{
    use QueueableAction;

    public function __construct(
        protected ToastMessage $toastMessage,
    ) {}

    public function execute(string $message): bool
    {
        return $this->toastMessage->execute($message, 'success');
    }
}
