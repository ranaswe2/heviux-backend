<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'image_name' => $this->faker->word .".png",
            'path' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph,
            'created_by' => $this->faker->numberBetween(5,6),
            'modified_by' => null, // Initially set to null
        ];
    }

}
