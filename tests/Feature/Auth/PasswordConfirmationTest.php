<?php

use App\Models\User;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the confirm password screen', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('password.confirm'))
        ->assertStatus(200);
});

it('can confirm password', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'password',
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();
});

it('cannot confirm password with invalid password', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors();
});
