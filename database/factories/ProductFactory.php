<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $status = ['active', 'draft', 'archived'];
        $name = $this->faker->words(4, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'compare_price' => $this->faker->randomFloat(2, 100, 1500),
            'image_path' => $this->faker->imageUrl(),
            'quantity' => $this->faker->randomNumber(2),
            'category_id' => Category::inRandomOrder()->limit(1)->first()->id,
            'status' => $status[rand(0, 2)],
            'reviews_count' => $this->faker->randomNumber(3),
            'reviews_avg' => $this->faker->randomFloat(1, 0, 5),
        ];
    }
}
