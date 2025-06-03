<?php

use App\Data\Auth\Register\RegisterRequest;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should render the registration screen', function () {
    get(route('register'))->assertOk();
});

it('should let new users register', function () {
    Notification::fake();

    post(
        route('register'),
        RegisterRequest::from([
            'first_name'            => 'Test',
            'last_name'             => 'User',
            'phone'                 => '0606060606',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ])->toArray(),
    )->assertRedirectToRoute('index');

    assertAuthenticated();
});
