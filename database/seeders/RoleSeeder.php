<?php

namespace Database\Seeders;

use App\Enums\Permission\PermissionName;
use App\Enums\Role\RoleName;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = Config::string('auth.defaults.guard');

        foreach (PermissionName::cases() as $permissionName) {
            Permission::findOrCreate($permissionName->value, $guard);
        }

        // reset cached roles and permissions again to allow setting them
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (RoleName::cases() as $roleName) {
            $role = Role::findOrCreate($roleName->value, $guard);
            $role->givePermissionTo(
                ...match ($roleName) {
                    RoleName::TESTER => PermissionName::cases(),
                    RoleName::OWNER  => PermissionName::cases(),
                    RoleName::MEMBER => [],
                    default          => []
                },
            );
        }
    }
}
