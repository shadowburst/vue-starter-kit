<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the reset password link screen', function () {
    /** @var TestCase $this */
    $this->get(route('password.request'))
        ->assertStatus(200);
});

it('lets users request a reset password link', function () {
    /** @var TestCase $this */
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

it('can render the reset password screen', function () {
    /** @var TestCase $this */
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    $this->post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $this->get(route('password.reset', ['token' => $notification->token]))
            ->assertStatus(200);

        return true;
    });
});

it('can reset password with valid token', function () {
    /** @var TestCase $this */
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    $this->post(route('password.request'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $this
            ->post(route('password.store'), [
                'token'                 => $notification->token,
                'email'                 => $user->email,
                'password'              => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});
