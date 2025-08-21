<?php
namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => Str::slug(fake()->sentence()),
            'author_id' => User::factory(),
            'article_category_id' => ArticleCategory::factory(),
            'body' => fake()->text(),
            'inovator' => fake()->name(),
            'seen' => 0,
            'image' =>'default.png',
        ];
    }
}
