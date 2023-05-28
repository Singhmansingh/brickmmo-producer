<?php

namespace Database\Factories;

use App\Models\SegmentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SegmentField>
 */
class SegmentFieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // force seeding segmentfields to be linked to report segment_type
        return [
            'segment_type_id' => 1,
            'field_name' => $this->faker->word(),
            'field_label' => $this->faker->word(),
            'field_data_type' => $this->faker->randomElement(['text','textarea']),
        ];
    }
}
