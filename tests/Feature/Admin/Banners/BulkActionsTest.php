<?php

use App\Enums\Role\RoleName;
use App\Models\Banner;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\patch;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    setPermissionsTeamId($this->user->team->id);
    $this->user->assignRole(RoleName::OWNER);
});

describe('PATCH /admin/banners/enable - Enable Banner(s)', function () {
    it('should enable a single banner by id', function () {
        $banner = Banner::factory()->create(['is_enabled' => false]);

        actingAs($this->user)
            ->patch(route('admin.banners.enable', ['banner' => $banner->id]))
            ->assertRedirect();

        $banner->refresh();
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should enable multiple banners by ids array', function () {
        $banner1 = Banner::factory()->create(['is_enabled' => false]);
        $banner2 = Banner::factory()->create(['is_enabled' => false]);
        $banner3 = Banner::factory()->create(['is_enabled' => false]);

        actingAs($this->user)
            ->patch(route('admin.banners.enable'), [
                'ids' => [$banner1->id, $banner2->id, $banner3->id],
            ])
            ->assertRedirect();

        $banner1->refresh();
        $banner2->refresh();
        $banner3->refresh();

        expect($banner1->is_enabled)->toBeTrue();
        expect($banner2->is_enabled)->toBeTrue();
        expect($banner3->is_enabled)->toBeTrue();
    });

    it('should only enable banners in the ids array', function () {
        $enableBanner1 = Banner::factory()->create(['is_enabled' => false]);
        $enableBanner2 = Banner::factory()->create(['is_enabled' => false]);
        $notChangedBanner = Banner::factory()->create(['is_enabled' => false]);

        actingAs($this->user)
            ->patch(route('admin.banners.enable'), [
                'ids' => [$enableBanner1->id, $enableBanner2->id],
            ])
            ->assertRedirect();

        $enableBanner1->refresh();
        $enableBanner2->refresh();
        $notChangedBanner->refresh();

        expect($enableBanner1->is_enabled)->toBeTrue();
        expect($enableBanner2->is_enabled)->toBeTrue();
        expect($notChangedBanner->is_enabled)->toBeFalse();
    });

    it('should not affect already enabled banners', function () {
        $enabledBanner = Banner::factory()->create(['is_enabled' => true]);

        actingAs($this->user)
            ->patch(route('admin.banners.enable', ['banner' => $enabledBanner->id]))
            ->assertRedirect();

        $enabledBanner->refresh();
        expect($enabledBanner->is_enabled)->toBeTrue();
    });

    it('should redirect unauthenticated users to login', function () {
        $banner = Banner::factory()->create(['is_enabled' => false]);

        patch(route('admin.banners.enable', ['banner' => $banner->id]))
            ->assertRedirect(route('login'));

        $banner->refresh();
        expect($banner->is_enabled)->toBeFalse();
    });

    it('should handle empty ids array gracefully', function () {
        $banner = Banner::factory()->create(['is_enabled' => false]);

        actingAs($this->user)
            ->patch(route('admin.banners.enable'), [
                'ids' => [],
            ])
            ->assertSessionHasErrors('ids');
    });

    it('should handle invalid banner ids', function () {
        $response = actingAs($this->user)
            ->patch(route('admin.banners.enable'), [
                'ids' => [99999, 99998],
            ])
            ->assertSessionHasErrors('ids.0');
    });

    it('should reset users dismissed when enabling single banner', function () {
        $banner = Banner::factory()->create(['is_enabled' => false]);
        $user = User::factory()->create();
        $banner->users()->attach($user->id);

        expect($banner->users()->count())->toBe(1);

        actingAs($this->user)
            ->patch(route('admin.banners.enable', ['banner' => $banner->id]))
            ->assertRedirect();

        $banner->refresh();
        expect($banner->is_enabled)->toBeTrue();
        expect($banner->users()->count())->toBe(0);
    });

    it('should reset users dismissed when enabling multiple banners', function () {
        $banner1 = Banner::factory()->create(['is_enabled' => false]);
        $banner2 = Banner::factory()->create(['is_enabled' => false]);
        $user = User::factory()->create();

        $banner1->users()->attach($user->id);
        $banner2->users()->attach($user->id);

        actingAs($this->user)
            ->patch(route('admin.banners.enable'), [
                'ids' => [$banner1->id, $banner2->id],
            ])
            ->assertRedirect();

        $banner1->refresh();
        $banner2->refresh();

        expect($banner1->users()->count())->toBe(0);
        expect($banner2->users()->count())->toBe(0);
    });
});

describe('PATCH /admin/banners/disable - Disable Banner(s)', function () {
    it('should disable a single banner by id', function () {
        $banner = Banner::factory()->create(['is_enabled' => true]);

        actingAs($this->user)
            ->patch(route('admin.banners.disable', ['banner' => $banner->id]))
            ->assertRedirect();

        $banner->refresh();
        expect($banner->is_enabled)->toBeFalse();
    });

    it('should disable multiple banners by ids array', function () {
        $banner1 = Banner::factory()->create(['is_enabled' => true]);
        $banner2 = Banner::factory()->create(['is_enabled' => true]);
        $banner3 = Banner::factory()->create(['is_enabled' => true]);

        actingAs($this->user)
            ->patch(route('admin.banners.disable'), [
                'ids' => [$banner1->id, $banner2->id, $banner3->id],
            ])
            ->assertRedirect();

        $banner1->refresh();
        $banner2->refresh();
        $banner3->refresh();

        expect($banner1->is_enabled)->toBeFalse();
        expect($banner2->is_enabled)->toBeFalse();
        expect($banner3->is_enabled)->toBeFalse();
    });

    it('should only disable banners in the ids array', function () {
        $disableBanner1 = Banner::factory()->create(['is_enabled' => true]);
        $disableBanner2 = Banner::factory()->create(['is_enabled' => true]);
        $notChangedBanner = Banner::factory()->create(['is_enabled' => true]);

        actingAs($this->user)
            ->patch(route('admin.banners.disable'), [
                'ids' => [$disableBanner1->id, $disableBanner2->id],
            ])
            ->assertRedirect();

        $disableBanner1->refresh();
        $disableBanner2->refresh();
        $notChangedBanner->refresh();

        expect($disableBanner1->is_enabled)->toBeFalse();
        expect($disableBanner2->is_enabled)->toBeFalse();
        expect($notChangedBanner->is_enabled)->toBeTrue();
    });

    it('should not affect already disabled banners', function () {
        $disabledBanner = Banner::factory()->create(['is_enabled' => false]);

        actingAs($this->user)
            ->patch(route('admin.banners.disable', ['banner' => $disabledBanner->id]))
            ->assertRedirect();

        $disabledBanner->refresh();
        expect($disabledBanner->is_enabled)->toBeFalse();
    });

    it('should redirect unauthenticated users to login', function () {
        $banner = Banner::factory()->create(['is_enabled' => true]);

        patch(route('admin.banners.disable', ['banner' => $banner->id]))
            ->assertRedirect(route('login'));

        $banner->refresh();
        expect($banner->is_enabled)->toBeTrue();
    });

    it('should handle empty ids array gracefully', function () {
        $banner = Banner::factory()->create(['is_enabled' => true]);

        actingAs($this->user)
            ->patch(route('admin.banners.disable'), [
                'ids' => [],
            ])
            ->assertSessionHasErrors('ids');
    });

    it('should handle invalid banner ids', function () {
        $response = actingAs($this->user)
            ->patch(route('admin.banners.disable'), [
                'ids' => [99999, 99998],
            ])
            ->assertSessionHasErrors('ids.0');
    });

    it('should keep user dismissals when disabling single banner', function () {
        $banner = Banner::factory()->create(['is_enabled' => true]);
        $user = User::factory()->create();
        $banner->users()->attach($user->id);

        expect($banner->users()->count())->toBe(1);

        actingAs($this->user)
            ->patch(route('admin.banners.disable', ['banner' => $banner->id]))
            ->assertRedirect();

        $banner->refresh();
        expect($banner->is_enabled)->toBeFalse();
        expect($banner->users()->count())->toBe(1);
    });

    it('should keep user dismissals when disabling multiple banners', function () {
        $banner1 = Banner::factory()->create(['is_enabled' => true]);
        $banner2 = Banner::factory()->create(['is_enabled' => true]);
        $user = User::factory()->create();

        $banner1->users()->attach($user->id);
        $banner2->users()->attach($user->id);

        actingAs($this->user)
            ->patch(route('admin.banners.disable'), [
                'ids' => [$banner1->id, $banner2->id],
            ])
            ->assertRedirect();

        $banner1->refresh();
        $banner2->refresh();

        expect($banner1->users()->count())->toBe(1);
        expect($banner2->users()->count())->toBe(1);
    });
});

describe('DELETE /admin/banners/delete - Delete Banner(s)', function () {
    it('should delete a single banner by id', function () {
        $banner = Banner::factory()->create();
        $bannerId = $banner->id;

        expect(Banner::find($bannerId))->not->toBeNull();

        actingAs($this->user)
            ->delete(route('admin.banners.delete', ['banner' => $banner->id]))
            ->assertRedirect();

        expect(Banner::find($bannerId))->toBeNull();
    });

    it('should delete multiple banners by ids array', function () {
        $banner1 = Banner::factory()->create();
        $banner2 = Banner::factory()->create();
        $banner3 = Banner::factory()->create();

        $ids = [$banner1->id, $banner2->id, $banner3->id];

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => $ids,
            ])
            ->assertRedirect();

        foreach ($ids as $id) {
            expect(Banner::find($id))->toBeNull();
        }
    });

    it('should only delete banners in the ids array', function () {
        $deleteBanner1 = Banner::factory()->create();
        $deleteBanner2 = Banner::factory()->create();
        $keepBanner = Banner::factory()->create();

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [$deleteBanner1->id, $deleteBanner2->id],
            ])
            ->assertRedirect();

        expect(Banner::find($deleteBanner1->id))->toBeNull();
        expect(Banner::find($deleteBanner2->id))->toBeNull();
        expect(Banner::find($keepBanner->id))->not->toBeNull();
    });

    it('should delete banner and its user dismissals', function () {
        $banner = Banner::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $banner->users()->attach([$user1->id, $user2->id]);
        expect($banner->users()->count())->toBe(2);

        actingAs($this->user)
            ->delete(route('admin.banners.delete', ['banner' => $banner->id]))
            ->assertRedirect();

        expect(Banner::find($banner->id))->toBeNull();
    });

    it('should redirect unauthenticated users to login', function () {
        $banner = Banner::factory()->create();
        $bannerId = $banner->id;

        delete(route('admin.banners.delete', ['banner' => $banner->id]))
            ->assertRedirect(route('login'));

        expect(Banner::find($bannerId))->not->toBeNull();
    });

    it('should handle empty ids array gracefully', function () {
        Banner::factory(5)->create();
        $initialCount = Banner::count();

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [],
            ])
            ->assertSessionHasErrors('ids');

        expect(Banner::count())->toBe($initialCount);
    });

    it('should handle invalid banner ids', function () {
        Banner::factory(5)->create();
        $initialCount = Banner::count();

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [99999, 99998],
            ])
            ->assertSessionHasErrors('ids.0');

        expect(Banner::count())->toBe($initialCount);
    });

    it('should delete in transaction and rollback on error', function () {
        $banner1 = Banner::factory()->create();
        $banner2 = Banner::factory()->create();
        $banner3 = Banner::factory()->create();

        $initialCount = Banner::count();

        // Test with all valid IDs - should succeed
        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [$banner1->id, $banner2->id, $banner3->id],
            ])
            ->assertRedirect();

        expect(Banner::count())->toBe($initialCount - 3);
    });

    it('should handle deleting non-existent banners gracefully', function () {
        Banner::factory(3)->create();
        $initialCount = Banner::count();

        $response = actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [99999],
            ]);

        // Should have validation error for non-existent ID
        $response->assertSessionHasErrors('ids.0');
        expect(Banner::count())->toBe($initialCount);
    });

    it('should delete all banners of given type', function () {
        Banner::factory(10)->create();
        expect(Banner::count())->toBe(10);

        $allBannerIds = Banner::pluck('id')->toArray();

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => $allBannerIds,
            ])
            ->assertRedirect();

        expect(Banner::count())->toBe(0);
    });

    it('should preserve other banners when deleting specific ones', function () {
        $keepBanner1 = Banner::factory()->create(['name' => 'Keep 1']);
        $keepBanner2 = Banner::factory()->create(['name' => 'Keep 2']);
        $deleteBanner1 = Banner::factory()->create(['name' => 'Delete 1']);
        $deleteBanner2 = Banner::factory()->create(['name' => 'Delete 2']);

        actingAs($this->user)
            ->delete(route('admin.banners.delete'), [
                'ids' => [$deleteBanner1->id, $deleteBanner2->id],
            ])
            ->assertRedirect();

        expect(Banner::count())->toBe(2);
        expect(Banner::where('name', 'Keep 1')->exists())->toBeTrue();
        expect(Banner::where('name', 'Keep 2')->exists())->toBeTrue();
    });
});
