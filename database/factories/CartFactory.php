<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class CartFactory extends Factory
{
    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 10),
            'size' => $this->faker->randomElement(['small', 'medium', 'large','xlarge','xxlarge','xxxlarge',]), // Adjust based on your size options
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
