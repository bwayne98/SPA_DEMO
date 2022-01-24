<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "enName" => $this->faker->name(),
            "birth" => $this->faker->date(),
            "phone" => "0" . strval($this->faker->numberBetween(900000000, 980000000)),
            "address" => $this->faker->address(),
        ];
    }
}
