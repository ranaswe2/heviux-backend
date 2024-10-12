<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    
    protected static ?string $password;

    
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber(),
            'image_name' => $this->faker->word .".png",
            'image_path' => $this->faker->imageUrl(),
            'password' => bcrypt('password'), // You may want to use Hash::make() in Laravel 8
            'address' => $this->faker->address,
            'is_admin' => false,
            'current_otp' => strval(rand(100000, 999999)),
            'is_verified' => $this->faker->boolean(),
        ];
    }

    
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
