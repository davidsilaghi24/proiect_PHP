<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Journalist;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'journalist_id' => Journalist::factory(),
        ];
    }
}
