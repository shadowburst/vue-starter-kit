<?php

use Tests\TestCase;

it('runs', function () {
    /** @var TestCase $this */
    $this->artisan('dev:install')
        ->expectsConfirmation('Reset database ?')
        ->expectsConfirmation('Generate fake data ?')
        ->assertSuccessful();
});

it('will not touch the database in production', function () {
    /** @var TestCase $this */
    mockProduction();
    $this->artisan('dev:install')
        ->expectsOutputToContain('Database will be ignored in production')
        ->doesntExpectOutput('Reset database ?')
        ->doesntExpectOutput('Generate fake data ?')
        ->assertSuccessful();
});
