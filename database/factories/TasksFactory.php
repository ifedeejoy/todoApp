<?php

namespace Database\Factories;

use App\Models\Tasks;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TasksFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tasks::class;
    protected $user = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(10, 150),
            'title' => $this->faker->word(),
            'description' => $this->faker->realText(150),
        ];
    }
}
