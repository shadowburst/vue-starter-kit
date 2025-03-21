<?php

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('can render the email verification screen', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->get(route('verification.notice'))
        ->assertStatus(200);
});

it('can verify email', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->email)],
    );

    $this->actingAs($user)
        ->get($verificationUrl)
        ->assertRedirect(config('fortify.home').'?verified=1');

    Event::assertDispatched(Verified::class);
    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
});

it('cannot verify email with invalid hash', function () {
    /** @var TestCase $this */

    /** @var User $user */
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1('wrong-email')],
    );

    $this->actingAs($user)
        ->get($verificationUrl);

    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});
