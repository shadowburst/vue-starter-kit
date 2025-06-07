<?php

namespace App\Actions\Toast;

use Spatie\QueueableAction\QueueableAction;

class ToastSuccessOrError
{
    use QueueableAction;

    /**
     * Create a new action instance.
     */
    public function __construct(
        protected ToastSuccess $toastSuccess,
        protected ToastError $toastError,
    ) {}

    /**
     * Execute the action.
     */
    public function execute(bool $success, string $successMessage, ?string $errorMessage = null): bool
    {
        return match ($success) {
            true    => $this->toastSuccess->execute($successMessage),
            default => $this->toastError->execute($errorMessage ?? __('messages.error'))
        };
    }
}
