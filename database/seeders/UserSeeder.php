<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->firstOrCreate(
                [
                    'is_admin' => true,
                ],
                [
                    'first_name'        => 'super',
                    'last_name'         => 'admin',
                    'email'             => 'super@admin.com',
                    'email_verified_at' => now(),
                    'password'          => 'Password-1234',
                ]);
    }
}
