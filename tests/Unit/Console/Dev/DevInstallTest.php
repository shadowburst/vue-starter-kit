<?php

use function Pest\Laravel\artisan;

it('should complete successfully', function () {
    artisan('dev:install')
        ->expectsConfirmation('Reset database ?')
        ->expectsConfirmation('Generate fake data ?')
        ->assertSuccessful();
});

it('should not change the database in production', function () {
    mockProduction();
    artisan('dev:install')
        ->expectsOutputToContain('Database will be ignored in production')
        ->doesntExpectOutput('Reset database ?')
        ->doesntExpectOutput('Generate fake data ?')
        ->assertSuccessful();
});
