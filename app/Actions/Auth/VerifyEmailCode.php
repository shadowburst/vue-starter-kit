<?php

namespace App\Actions\Auth;

use App\Data\Auth\VerifyEmail\VerifyEmailRequest;
use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\QueueableAction\QueueableAction;

class VerifyEmailCode
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
    public function execute(User $user, VerifyEmailRequest $request): bool
    {
        /** @var ?EmailVerificationToken $token */
        $token = EmailVerificationToken::query()
            ->whereEmail($user->email)
            ->whereFuture('expires_at')
            ->first();

        if (! $token) {
            return false;
        }

        if (! Hash::check($request->code, $token->token)) {
            return false;
        }

        return $token->delete();
    }
}
