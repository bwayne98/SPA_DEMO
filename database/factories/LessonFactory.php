<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rooms = ["2A","2S","2B", "3A", "3S", "3B", "4A", "4S", "4B"];
        $levels = ["Y1","Y2","Y3","Y4","R5","R6","R7","R8","R9","R10"];
        $codes = ["X","Y","Z"];

        return [
            'name' => Arr::random($levels).Arr::random($codes),
            'room' => Arr::random($rooms)
        ];
    }
}
