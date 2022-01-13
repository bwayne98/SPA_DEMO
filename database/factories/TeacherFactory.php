<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */



    public function definition()
    {
        $word = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
        $pri = ["1","2","1","2","1","2","2","1"];

        return [
            "chName" => $this->faker->firstName(),
            "enName" => $this->faker->lastName(),
            "birth" => $this->faker->date(),
            "idNumber" => Arr::random($word).Arr::random($pri).strval($this->faker->numberBetween(10000000,69999999)),
            "phone" => "0".strval($this->faker->numberBetween(900000000,980000000)),
            "address" => $this->faker->address(),
        ];
    }
}
