<?php

namespace Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailVerificationToken>
 */
class EmailVerificationTokenFactory extends Factory
{
    protected static ?string $token;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'      => fake()->unique()->safeEmail(),
            'token'      => static::$token ??= Hash::make('123456'),
            'expires_at' => now()->addMinutes(30),
        ];
    }
}
