<?php

namespace Database\Factories;

use App\Enums\TaskStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TaskFactory extends Factory
{
    public function configure()
    {
        $this->faker = \Faker\Factory::create('ru_RU');
        return parent::configure();
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $description = PHP_EOL . $this->faker->sentence(3) . PHP_EOL;
        for($i = 0; $i <=3; $i++ ) {
            $description .= PHP_EOL . $this->faker->paragraph(random_int(2, 6)) . PHP_EOL;
        }
        return [
            'title' => $this->faker->sentence(3),
            'description' => $description,
            'start_day' => $this->faker->dateTimeBetween('-1month', 'now'),
            'end_day' => $this->faker->dateTimeBetween('now', '+1week'),
            'user_id' => User::all()->random()->id,
            'status' => TaskStatusEnum::randomValue(),
        ];
    }
}
