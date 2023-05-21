<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternalSystem>
 */
class InternalSystemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system_name' => $this->faker->sentence,
            'request_api_url' => $this->faker->sentence,
            'system_icon' => $this->faker->sentence,
        ];
    }
}
