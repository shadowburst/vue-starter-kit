<?php

use App\Enums\Role\RoleName;
use App\Models\Banner;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('PUT /admin/banners/edit/{banner} - Update Banner', function () {
    it('should update a banner with valid data', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Original Name',
            'message'    => 'Original message',
            'action'     => null,
            'is_enabled' => false,
        ]);

        $updateData = [
            'name'       => 'Updated Name',
            'message'    => 'Updated message',
            'action'     => 'https://example.com/new',
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->name)->toBe('Updated Name');
        expect($banner->message)->toBe('Updated message');
        expect($banner->action)->toBe('https://example.com/new');
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should update only the name field', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Original Name',
            'message'    => 'Original message',
            'action'     => 'https://example.com/original',
            'is_enabled' => true,
        ]);

        $updateData = [
            'name'       => 'New Name Only',
            'message'    => 'Original message',
            'action'     => 'https://example.com/original',
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->name)->toBe('New Name Only');
        expect($banner->message)->toBe('Original message');
    });

    it('should update only the message field', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Test Banner',
            'message'    => 'Original message',
            'action'     => null,
            'is_enabled' => false,
        ]);

        $updateData = [
            'name'       => 'Test Banner',
            'message'    => 'New message content',
            'action'     => null,
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->message)->toBe('New message content');
    });

    it('should update is_enabled from false to true', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => null,
            'is_enabled' => false,
        ]);

        $updateData = [
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => null,
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should update is_enabled from true to false', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => 'https://example.com',
            'is_enabled' => true,
        ]);

        $updateData = [
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => 'https://example.com',
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->is_enabled)->toBeFalse();
    });

    it('should set action to null', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => 'https://example.com/action',
            'is_enabled' => true,
        ]);

        $updateData = [
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => null,
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->action)->toBeNull();
    });

    it('should update action from null to URL', function () {
        $banner = Banner::factory()->create([
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => null,
            'is_enabled' => true,
        ]);

        $updateData = [
            'name'       => 'Test Banner',
            'message'    => 'Test message',
            'action'     => 'https://example.com/new-action',
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        expect($banner->action)->toBe('https://example.com/new-action');
    });

    it('should redirect unauthenticated users to login', function () {
        $banner = Banner::factory()->create();

        put(
            route('admin.banners.update', ['banner' => $banner->id]),
            [
                'name'       => 'Updated',
                'message'    => 'Updated',
                'action'     => null,
                'is_enabled' => true,
            ],
        )->assertRedirect(route('login'));

        $banner->refresh();
        expect($banner->name)->not->toBe('Updated');
    });

    it('should return 404 for non-existent banner', function () {
        actingAs($this->user)
            ->put(
                route('admin.banners.update', ['banner' => 99999]),
                [
                    'name'       => 'Updated',
                    'message'    => 'Updated',
                    'action'     => null,
                    'is_enabled' => true,
                ],
            )
            ->assertNotFound();
    });

    it('should handle empty string name as invalid', function () {
        $banner = Banner::factory()->create();

        $response = actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), [
                'name'       => '',
                'message'    => 'Valid message',
                'action'     => null,
                'is_enabled' => true,
            ]);

        $response->assertSessionHasErrors('name');
        $banner->refresh();
        expect($banner->name)->not->toBe('');
    });

    it('should handle empty string message as invalid', function () {
        $banner = Banner::factory()->create();

        $response = actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), [
                'name'       => 'Valid name',
                'message'    => '',
                'action'     => null,
                'is_enabled' => true,
            ]);

        $response->assertSessionHasErrors('message');
    });

    it('should reset user dismissals when enabling a banner', function () {
        $banner = Banner::factory()->create(['is_enabled' => false]);
        $user = User::factory()->create();

        // Attach users to banner (they have dismissed it)
        $banner->users()->attach($user->id);
        expect($banner->users()->count())->toBe(1);

        // Update banner to be enabled
        $updateData = [
            'name'       => $banner->name,
            'message'    => $banner->message,
            'action'     => $banner->action,
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        // Users should be cleared when banner is re-enabled
        expect($banner->users()->count())->toBe(0);
    });

    it('should keep user dismissals when disabling a banner', function () {
        $banner = Banner::factory()->create(['is_enabled' => true]);
        $user = User::factory()->create();

        $banner->users()->attach($user->id);
        expect($banner->users()->count())->toBe(1);

        $updateData = [
            'name'       => $banner->name,
            'message'    => $banner->message,
            'action'     => $banner->action,
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->put(route('admin.banners.update', ['banner' => $banner->id]), $updateData)
            ->assertRedirect(route('admin.banners.index'));

        $banner->refresh();
        // Users should remain when just disabling
        expect($banner->users()->count())->toBe(1);
    });
});
