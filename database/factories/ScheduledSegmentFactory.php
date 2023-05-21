<?php

namespace Database\Factories;

use App\Models\Music;
use App\Models\Script;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduledSegment>
 */
class ScheduledSegmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'scheduled_for' => now(),
            'music_id' => Music::all()->random(),
            'script_id' => Script::all()->random(),
        ]; 
    }
}
