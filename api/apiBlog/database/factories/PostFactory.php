<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->realText(50),
            'slug' => $this->faker->slug,
            'description' => $this->faker->text(200),
            'content' => $this->faker->paragraphs(2, 6),
            'published' => true
        ];
    }
}
