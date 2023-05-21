<?php

namespace Database\Factories;

use App\Models\SegmentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubSegmentType>
 */
class SubSegmentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $segmentType = SegmentType::factory()->create();
    
        return [
            'segment_type_id' => SegmentType::all()->random(),
            'sub_segment_name' => $this->faker->sentence,
        ];
    }
}
