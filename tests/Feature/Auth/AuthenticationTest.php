<?php

use App\Models\User;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the login page', function () {
    /** @var TestCase $this */
    $this->get(route('login'))
        ->assertOk();
});

it('can authenticate users using the login screen', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this
        ->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect(route('dashboard', absolute: false));
    $this->assertAuthenticatedAs($user);
});

it('cannot authenticate users with an invalid password', function () {
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

it('lets users logout', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
