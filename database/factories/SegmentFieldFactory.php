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
    
        return [
            'segment_type_id' => SegmentType::all()->random(),
            'field_name' => $this->faker->sentence,
            'field_data_type' => $this->faker->sentence,
        ];
    }
}
