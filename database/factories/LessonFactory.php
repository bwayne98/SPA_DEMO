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
  
        $levels = ["Y1","Y2","Y3","Y4","R5","R6","R7","R8","R9","R10"];
        $codes = ["X","Y","Z"];

        return [
            'name' => Arr::random($levels).Arr::random($codes),
        ];
    }
}
