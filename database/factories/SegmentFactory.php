<?php

namespace Database\Factories;

use App\Models\Reporter;
use App\Models\SegmentField;
use App\Models\User;
use App\Models\InternalSystem;
use App\Models\SegmentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Segment>
 */
class SegmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reportsegmentfields = SegmentField::all()->where('segment_type_id','=',1);

        $segmentData = array();

        foreach ($reportsegmentfields as $field)
        {
            $segmentData[$field->field_name] = $this->faker->sentence(7);
        }

        $segmentDataJson=json_encode($segmentData);


        return [
            'title' => $this->faker->sentence,
            'segment_data' => $segmentDataJson,
            'segment_image' => $this->faker->sentence,
            'user_id' => User::all()->random(),
            'internal_system_id' => InternalSystem::all()->random(),
            'segment_type_id' => SegmentType::all()->random(),
        ];
    }
}
