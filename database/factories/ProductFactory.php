<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
  
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'category' => $this->faker->word,
            'sub_category' => $this->faker->word,
            'fabric' => $this->faker->word,
            'GSM' => $this->faker->randomNumber(3),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'description' => $this->faker->paragraph,
            'created_by' => $this->faker->numberBetween(5,6),
            'modified_by' => null, // Initially set to null
        ];
    }

    
}
