<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSize>
 */
class ProductSizeFactory extends Factory
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
            'small' => $this->faker->numberBetween(0, 100),
            'medium' => $this->faker->numberBetween(0, 100),
            'large' => $this->faker->numberBetween(0, 100),
            'xlarge' => $this->faker->numberBetween(0, 100),
            'xxlarge' => $this->faker->numberBetween(0, 100),
            'xxxlarge' => $this->faker->numberBetween(0, 100),
            'created_by' => $this->faker->numberBetween(5,6),
            'modified_by' => null, // Initially set to null
        ];
    }
}
