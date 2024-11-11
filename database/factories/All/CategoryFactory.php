<?php

namespace Database\Factories\All;

use App\Models\All\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\All\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'slug' => Str::slug($this->faker->unique()->word),
        ];

        
    }
}
