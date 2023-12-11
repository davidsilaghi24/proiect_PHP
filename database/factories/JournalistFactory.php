<?php

namespace Database\Factories;

use App\Models\Journalist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JournalistFactory extends Factory
{
    protected $model = Journalist::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'biography' => $this->faker->paragraph,
        ];
    }
}
