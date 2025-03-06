<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the registration screen', function () {
    $this->get(route('register'))
        ->assertStatus(200);
});

it('lets new users register', function () {
    $this
        ->post('/register', [
            'first_name'            => 'Test',
            'last_name'             => 'User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
