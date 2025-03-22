<?php

use App\Models\User;

use function Pest\Laravel\actingAs;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the confirm password screen', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('password.confirm'))
        ->assertOk();
});

it('should let users confirm their password', function () {
    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

it('should not confirm an invalid password', function () {

    /** @var User $user */
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors();
});
