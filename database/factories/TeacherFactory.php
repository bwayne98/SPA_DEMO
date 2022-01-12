<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "chName" => $this->faker->firstName(),
            "enName" => $this->faker->lastName(),
            "birth" => $this->faker->date(),
            "idNumber" => 'p123456789',
            "phone" => $this->faker->numberBetween(900000000,980000000),
            "address" => $this->faker->address(),
        ];
    }
}
