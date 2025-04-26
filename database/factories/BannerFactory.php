<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $end = fake()->dateTime('+1 year');

        return [
            'name'      => fake()->domainName,
            'message'   => fake()->text,
            'action'    => fake()->url,
            'starts_at' => fake()->dateTime($end),
            'ends_at'   => $end,
        ];
    }
}
