<?php

use App\Data\Auth\ForgotPassword\ForgotPasswordRequest;
use App\Data\Auth\ResetPassword\ResetPasswordProps;
use App\Data\Auth\ResetPassword\ResetPasswordRequest;
use App\Models\User;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\followingRedirects;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the reset password link screen', function () {
get(route('password.request'))
->assertOk();
    });

it('should let users request a reset password link', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    followingRedirects()
        ->post(
            route('password.email'),
            ForgotPasswordRequest::from([
                'email' => $user->email,
            ])->toArray(),
        )->assertOk();

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

it('should render the reset password screen', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    followingRedirects()
        ->post(
            route('password.email'),
            ForgotPasswordRequest::from([
                'email' => $user->email,
            ])->toArray(),
        )->assertOk();

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {
        get(
            route(
                'password.reset',
                ResetPasswordProps::from([
                    'token' => $notification->token,
                    'email' => $user->email,
                ])->toArray(),
            ),
        )->assertOk();

        return true;
        });
});

it('should reset password with valid token', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    followingRedirects()
        ->post(
            route('password.request'),
            ForgotPasswordRequest::from([
                'email' => $user->email,
            ])->toArray(),
        )->assertOk();

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {
            post(
                route('password.update'),
                ResetPasswordRequest::from([
                    'token'                 => $notification->token,
                    'email'                 => $user->email,
                    'password'              => 'password',
                    'password_confirmation' => 'password',
                ])->toArray(),
            )
                ->assertSessionHasNoErrors()
                ->assertRedirectToRoute('login');

            return true;
        });
});

it('should not reset password with invalid token', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    followingRedirects()
        ->post(
            route('password.request'),
            ForgotPasswordRequest::from([
                'email' => $user->email,
            ])->toArray(),
        )->assertOk();

    Notification::assertSentTo(
        $user,
        ResetPasswordNotification::class,
        function (ResetPasswordNotification $notification) use ($user) {
            post(
                route('password.update'),
                ResetPasswordRequest::from([
                    'token'                 => str_shuffle($notification->token),
                    'email'                 => $user->email,
                    'password'              => 'password',
                    'password_confirmation' => 'password',
                ])->toArray(),
            )->assertSessionHasErrors();

            return true;
        });
});
