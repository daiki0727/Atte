<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('2024-03-01', '2024-04-30')->format('Y-m-d'),
            'work_start' => $this->faker->time(),
            'work_end' => $this->faker->time(),
        ];
    }
}
