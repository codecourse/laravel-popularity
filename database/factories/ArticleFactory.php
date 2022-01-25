<?php

namespace Codecourse\LaravelPopularity\Database\Factories;

use Codecourse\LaravelPopularity\Tests\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10)
        ];
    }
}
