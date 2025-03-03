<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\QueueableAction\QueueableAction;

class Login
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute(LoginRequest $data): bool
    {
        $this->ensureIsNotRateLimited($data);

        $success = Auth::attempt($data->only('email', 'password')->toArray(), $data->remember);

        if (! $success) {
            RateLimiter::hit($this->throttleKey($data));

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($data));

        request()->session()->regenerate();

        return true;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensureIsNotRateLimited(LoginRequest $data): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($data), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey($data));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(LoginRequest $data): string
    {
        return Str::transliterate(Str::lower($data->email).'|'.request()->ip());
    }
}
