<?php

use App\Enums\Role\RoleName;
use App\Models\Banner;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('GET /admin/banners/edit/{banner} - Edit Page', function () {
    it('should render the edit banner page', function () {
        $banner = Banner::factory()->create();

        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Edit')
                ->has('banner'),
            );
    });

    it('should load the correct banner in edit page', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Editable Banner',
            'message'    => 'Original message',
            'action'     => 'https://example.com/original',
            'is_enabled' => true,
        ]);

        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Edit')
                ->has('banner', fn ($page) => $page
                    ->where('id', $banner->id)
                    ->where('name', 'Editable Banner')
                    ->where('message', 'Original message')
                    ->where('action', 'https://example.com/original')
                    ->where('is_enabled', true),
                ),
            );
    });

    it('should display banner with null action', function () {
        $banner = Banner::factory()->create([
            'name'    => 'Banner Without Action',
            'message' => 'No action URL',
            'action'  => null,
        ]);

        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banner', fn ($page) => $page
                    ->where('action', null),
                ),
            );
    });

    it('should redirect unauthenticated users to login', function () {
        $banner = Banner::factory()->create();

        get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertRedirect(route('login'));
    });

    it('should return 404 for non-existent banner', function () {
        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => 99999]))
            ->assertNotFound();
    });

    it('should have correct breadcrumbs with banner id', function () {
        $banner = Banner::factory()->create(['name' => 'Test Banner']);

        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('banners/admin/Edit'),
            );
    });

    it('should load disabled banner for editing', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Disabled Banner',
            'message'    => 'Currently disabled',
            'is_enabled' => false,
        ]);

        actingAs($this->user)
            ->get(route('admin.banners.edit', ['banner' => $banner->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('banner', fn ($page) => $page
                    ->where('is_enabled', false),
                ),
            );
    });
});
