<?php

use App\Data\Auth\VerifyEmail\VerifyEmailRequest;
use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\followingRedirects;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the email verification screen', function () {
    /** @var User $user */
    $user = User::factory()->unverified()->create();

    actingAs($user)
        ->get(route('verification.notice'))
        ->assertOk();
});

it('should let users request a new code', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    followingRedirects()
        ->actingAs($user)
        ->post(route('verification.send'))
        ->assertOk();

    Notification::assertSentTo($user, VerifyEmailNotification::class);
});

it('should let users verify their email', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    followingRedirects()
        ->actingAs($user)
        ->post(route('verification.send'))
        ->assertOk();

    Notification::assertSentTo(
        $user,
        VerifyEmailNotification::class,
        function (VerifyEmailNotification $notification) use ($user) {
            Event::fake();

            followingRedirects()
                ->actingAs($user)
                ->post(
                    route('verification.code'),
                    VerifyEmailRequest::from([
                        'code' => $notification->code,
                    ])->toArray(),
                )->assertOk();

            Event::assertDispatched(Verified::class);
            expect($user->fresh()->hasVerifiedEmail())->toBeTrue();

            return true;
        },
    );

});

it('cannot verify email with invalid hash', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    followingRedirects()
        ->actingAs($user)
        ->post(route('verification.send'))
        ->assertOk();

    Notification::assertSentTo(
        $user,
        VerifyEmailNotification::class,
        function (VerifyEmailNotification $notification) use ($user) {
            followingRedirects()
                ->actingAs($user)
                ->post(
                    route('verification.code'),
                    VerifyEmailRequest::from([
                        'code' => str_shuffle($notification->code),
                    ])->toArray(),
                );

            expect($user->fresh()->hasVerifiedEmail())->toBeFalse();

            return true;
        },
    );
});
