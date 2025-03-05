<?php

use Tests\TestCase;

it('runs', function () {
    /** @var TestCase $this */
    $this->artisan('dev:user')
        ->expectsQuestion('First name', 'Super')
        ->expectsQuestion('Last name', 'Admin')
        ->expectsQuestion('Email', 'super@admin.com')
        ->expectsQuestion('Password', 'password')
        ->assertSuccessful();

    $this->assertDatabaseHas('users', ['email' => 'super@admin.com']);
});
