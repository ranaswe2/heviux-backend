<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class MessageFactory extends Factory
{
    
    public function definition()
    {
        return [
            'sender_id' => $this->faker->numberBetween(3,8),
            'receiver_id' => $this->faker->numberBetween(3,8),
            'text' => $this->faker->sentence,
            'image_path' => $this->faker->imageUrl,
        ];
    }
}
