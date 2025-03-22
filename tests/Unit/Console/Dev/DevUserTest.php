<?php

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseHas;

it('should insert a new user into the database', function () {
    artisan('dev:user')
        ->expectsQuestion('First name', 'Super')
        ->expectsQuestion('Last name', 'Admin')
        ->expectsQuestion('Email', 'super@admin.com')
        ->expectsQuestion('Password', 'password')
        ->assertSuccessful();

    assertDatabaseHas('users', ['email' => 'super@admin.com']);
});
