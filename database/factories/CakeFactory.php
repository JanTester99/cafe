<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CakeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Cake no. '.rand(1, 100),
            'description' => 'Fake cake',
            'price' => 0.1 * rand(20,200)
        ];
    }
}
