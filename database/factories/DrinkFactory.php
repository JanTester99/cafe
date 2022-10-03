<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DrinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Coffee no. '.rand(1, 100),
            'description' => 'Fake coffe',
            'brewing_time' => rand(10, 30),
            'price' => 0.1 * rand(20,200)
        ];
    }
}
