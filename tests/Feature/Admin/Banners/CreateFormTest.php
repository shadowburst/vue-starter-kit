<?php

use App\Enums\Role\RoleName;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('GET /admin/banners/create - Create Page', function () {
    it('should render the create banner page', function () {
        actingAs($this->user)
            ->get(route('admin.banners.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Create'),
            );
    });

    it('should redirect unauthenticated users to login', function () {
        get(route('admin.banners.create'))
            ->assertRedirect(route('login'));
    });

    it('should have correct breadcrumbs', function () {
        actingAs($this->user)
            ->get(route('admin.banners.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Create'),
            );
    });
});
