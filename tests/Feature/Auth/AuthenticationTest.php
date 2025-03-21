<?php

use App\Models\User;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the login page', function () {
    /** @var TestCase $this */
    $this->get(route('login'))
        ->assertOk();
});

it('should authenticate users using their password', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this
        ->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect(config('fortify.home'));
    $this->assertAuthenticatedAs($user);
});

it('should not authenticate users with an invalid password', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this
        ->post(route('login'), [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);
    $this->assertGuest();
});

it('should logout users', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
