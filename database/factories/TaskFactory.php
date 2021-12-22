<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => User::all()->random(1)->first()->id,
            'limit_date' => $this->faker->dateTimeBetween('-1 days', '+30 days'),
        ];
    }
}
