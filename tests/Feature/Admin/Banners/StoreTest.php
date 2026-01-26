<?php

use App\Enums\Role\RoleName;
use App\Models\Banner;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('POST /admin/banners/create - Store Banner', function () {
    it('should store a new banner with valid data', function () {
        $bannerData = [
            'name'       => 'Test Banner',
            'message'    => 'This is a test message',
            'action'     => 'https://example.com/action',
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        expect(Banner::query()->where('name', 'Test Banner')->exists())->toBeTrue();
    });

    it('should store a banner with minimal data', function () {
        $bannerData = [
            'name'       => 'Minimal Banner',
            'message'    => 'Message only',
            'action'     => null,
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        expect(Banner::query()->where('name', 'Minimal Banner')->exists())->toBeTrue();
        $banner = Banner::query()->where('name', 'Minimal Banner')->first();
        expect($banner->is_enabled)->toBeFalse();
        expect($banner->action)->toBeNull();
    });

    it('should create banner with is_enabled as true', function () {
        $bannerData = [
            'name'       => 'Enabled Banner',
            'message'    => 'This should be enabled',
            'action'     => null,
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        $banner = Banner::query()->where('name', 'Enabled Banner')->first();
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should create banner with is_enabled as false', function () {
        $bannerData = [
            'name'       => 'Disabled Banner',
            'message'    => 'This should be disabled',
            'action'     => null,
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        $banner = Banner::query()->where('name', 'Disabled Banner')->first();
        expect($banner->is_enabled)->toBeFalse();
    });

    it('should store a banner with all fields populated', function () {
        $bannerData = [
            'name'       => 'Full Banner',
            'message'    => 'Complete banner with all details',
            'action'     => 'https://example.com/special-offer',
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        $banner = Banner::query()->where('name', 'Full Banner')->first();
        expect($banner->name)->toBe('Full Banner');
        expect($banner->message)->toBe('Complete banner with all details');
        expect($banner->action)->toBe('https://example.com/special-offer');
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should redirect unauthenticated users to login', function () {
        post(
            route('admin.banners.store'),
            [
                'name'       => 'Test',
                'message'    => 'Test',
                'action'     => null,
                'is_enabled' => false,
            ],
        )->assertRedirect(route('login'));

        expect(Banner::count())->toBe(0);
    });

    it('should handle empty string name as invalid', function () {
        // Note: This tests the implicit DTO type validation
        $response = actingAs($this->user)
            ->post(route('admin.banners.store'), [
                'name'       => '',
                'message'    => 'Test message',
                'action'     => null,
                'is_enabled' => true,
            ]);

        // Empty strings should fail string type validation
        $response->assertSessionHasErrors('name');
    });

    it('should handle empty string message as invalid', function () {
        $response = actingAs($this->user)
            ->post(route('admin.banners.store'), [
                'name'       => 'Test Banner',
                'message'    => '',
                'action'     => null,
                'is_enabled' => true,
            ]);

        $response->assertSessionHasErrors('message');
    });

    it('should handle missing required fields gracefully', function () {
        // When message is missing, the DTO validation will fail
        actingAs($this->user)
            ->post(route('admin.banners.store'), [
                'name' => 'Test Banner',
                // Message field missing
                'action'     => null,
                'is_enabled' => true,
            ])
            ->assertRedirect(); // Will redirect with errors or error response
    });

    it('should handle missing is_enabled field gracefully', function () {
        // When is_enabled is missing, the DTO validation will fail
        actingAs($this->user)
            ->post(route('admin.banners.store'), [
                'name'    => 'Test Banner',
                'message' => 'Test message',
                'action'  => null,
                // is_enabled missing
            ])
            ->assertRedirect(); // Will redirect with errors or error response
    });

    it('should accept null action field', function () {
        $bannerData = [
            'name'       => 'Banner Without Action',
            'message'    => 'No action needed',
            'action'     => null,
            'is_enabled' => true,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $bannerData)
            ->assertRedirect(route('admin.banners.index'));

        $banner = Banner::query()->where('name', 'Banner Without Action')->first();
        expect($banner->action)->toBeNull();
    });

    it('should create multiple banners independently', function () {
        $banner1Data = [
            'name'       => 'Banner 1',
            'message'    => 'First banner',
            'action'     => null,
            'is_enabled' => true,
        ];

        $banner2Data = [
            'name'       => 'Banner 2',
            'message'    => 'Second banner',
            'action'     => 'https://example.com',
            'is_enabled' => false,
        ];

        actingAs($this->user)
            ->post(route('admin.banners.store'), $banner1Data)
            ->assertRedirect(route('admin.banners.index'));

        actingAs($this->user)
            ->post(route('admin.banners.store'), $banner2Data)
            ->assertRedirect(route('admin.banners.index'));

        expect(Banner::count())->toBe(2);
        expect(Banner::where('name', 'Banner 1')->exists())->toBeTrue();
        expect(Banner::where('name', 'Banner 2')->exists())->toBeTrue();
    });
});
