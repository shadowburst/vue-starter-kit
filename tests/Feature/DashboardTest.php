<?php

use App\Models\User;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('redirects guests to the login page', function () {
    /** @var TestCase $this */
    $this->get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('lets authenticated users visit the dashboard', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertStatus(200);
});
