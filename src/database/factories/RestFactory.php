<?php

namespace Database\Factories;

use App\Models\Rest;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'work_id' => \App\Models\Work::inRandomOrder()->first()->id,
            'rest_start' => $this->faker->time(),
            'rest_end' => $this->faker->time(),
        ];
    }
}