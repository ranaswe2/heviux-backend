<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'process_id' => Order::inRandomOrder()->first()->process_id,
            'total_amount' => $this->faker->randomFloat(2, 10, 500),
            'transaction_id' => $this->faker->unique()->uuid,
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
