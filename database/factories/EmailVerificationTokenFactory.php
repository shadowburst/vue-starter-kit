<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailVerificationToken>
 */
class EmailVerificationTokenFactory extends Factory
{
    protected static ?string $code;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email'      => fake()->unique()->safeEmail(),
            'token'      => static::$code ??= bcrypt('123456'),
            'created_at' => now(),
        ];
    }
}
