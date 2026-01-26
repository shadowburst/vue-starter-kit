<?php

use App\Enums\Role\RoleName;
use App\Models\Banner;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    /** @var User $user */
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('GET /admin/banners - Index Page', function () {
    it('should render the banners index page', function () {
        actingAs($this->user)
            ->get(route('admin.banners.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Index'),
            );
    });

    it('should redirect unauthenticated users to login', function () {
        get(route('admin.banners.index'))
            ->assertRedirect(route('login'));
    });

    it('should load banners with pagination', function () {
        Banner::factory(25)->create();

        actingAs($this->user)
            ->get(route('admin.banners.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 15)
                ->has('banners.meta'),
            );
    });

    it('should search banners by name', function () {
        $banner = Banner::factory()->create(['name' => 'Marketing Banner']);
        Banner::factory(3)->create(['name' => 'Other Banner']);

        actingAs($this->user)
            ->get(route('admin.banners.index', ['q' => 'Marketing']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 1)
                ->has('banners.data.0', fn ($page) => $page
                    ->where('name', 'Marketing Banner'),
                ),
            );
    });

    it('should search banners by message', function () {
        $banner = Banner::factory()->create(['message' => 'Special promotion details']);
        Banner::factory(3)->create(['message' => 'Regular message']);

        actingAs($this->user)
            ->get(route('admin.banners.index', ['q' => 'promotion']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 1),
            );
    });

    it('should filter banners by is_enabled status', function () {
        Banner::factory(3)->create(['is_enabled' => true]);
        Banner::factory(2)->create(['is_enabled' => false]);

        actingAs($this->user)
            ->get(route('admin.banners.index', ['is_enabled' => 'true']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 3),
            );

        actingAs($this->user)
            ->get(route('admin.banners.index', ['is_enabled' => 'false']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 2),
            );
    });

    it('should sort banners by column', function () {
        $banner1 = Banner::factory()->create(['name' => 'Alpha']);
        $banner2 = Banner::factory()->create(['name' => 'Beta']);
        $banner3 = Banner::factory()->create(['name' => 'Gamma']);

        actingAs($this->user)
            ->get(route('admin.banners.index', ['sort_by' => 'name', 'sort_direction' => 'asc']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data.0', fn ($page) => $page
                    ->where('name', 'Alpha'),
                ),
            );
    });

    it('should support custom pagination per_page', function () {
        Banner::factory(50)->create();

        actingAs($this->user)
            ->get(route('admin.banners.index', ['per_page' => 25]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 25),
            );
    });

    it('should handle empty search results gracefully', function () {
        Banner::factory(5)->create();

        actingAs($this->user)
            ->get(route('admin.banners.index', ['q' => 'nonexistent']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 0),
            );
    });

    it('should combine search and filter parameters', function () {
        Banner::factory()->create(['name' => 'Active Promo', 'is_enabled' => true]);
        Banner::factory()->create(['name' => 'Active Other', 'is_enabled' => true]);
        Banner::factory()->create(['name' => 'Inactive Promo', 'is_enabled' => false]);

        actingAs($this->user)
            ->get(route('admin.banners.index', ['q' => 'Promo', 'is_enabled' => 'true']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banners.data', 1)
                ->has('banners.data.0', fn ($page) => $page
                    ->where('name', 'Active Promo'),
                ),
            );
    });
});
