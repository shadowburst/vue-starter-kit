<?php

use App\Data\Auth\Login\LoginRequest;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the login page', function () {
get(route('login'))
->assertOk();
    });

it('should authenticate users using their password', function () {
    /** @var User $user */
    $user = User::factory()->create();

    post(
        route('login'),
        LoginRequest::from([
            'email'    => $user->email,
            'password' => 'password',
        ])->toArray(),
    )->assertRedirectToRoute('dashboard');

    assertAuthenticatedAs($user);
});

it('should not authenticate users with an invalid password', function () {
    /** @var User $user */
    $user = User::factory()->create();

    post(
        route('login'),
        LoginRequest::from([
            'email'    => $user->email,
            'password' => 'wrong-password',
        ])->toArray(),
    );

    assertGuest();
});

it('should logout users', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('logout'))
        ->assertRedirectToRoute('home');

    assertGuest();
});
