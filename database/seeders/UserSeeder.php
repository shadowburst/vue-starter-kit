<?php

namespace Database\Seeders;

use App\Enums\Role\RoleName;
use App\Facades\Services;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()
            ->firstOrCreate(
                [
                    'is_admin' => true,
                ],
                [
                    'team_id'           => Services::team()->createDefault->execute()->id,
                    'first_name'        => 'super',
                    'last_name'         => 'admin',
                    'email'             => 'super@admin.com',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('Password-1234'),
                ]);

        if ($user->wasRecentlyCreated) {
            Services::team()->forTeam(
                $user->team_id,
                fn () => $user->assignRole(RoleName::OWNER, RoleName::EDITOR),
            );
        }
    }
}
