<?php

use App\Enums\Role\RoleName;
use App\Facades\Services;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('should redirect guests to the login page', function () {
    get(route('index'))
        ->assertRedirect(route('login'));
});

it('should let authenticated users visit the dashboard', function () {
    /** @var User $user */
    $user = User::factory()->create();
    Services::team()->forTeam(
        $user->team,
        fn () => $user->assignRole(RoleName::OWNER),
    );

    actingAs($user)
        ->get(route('index'))
        ->assertOk();
});
