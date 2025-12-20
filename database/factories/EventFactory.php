<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'user_id' => 1, // Will be overridden when called
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'date_event' => $this->faker->dateTimeBetween('now', '+1 year'),
            'location' => $this->faker->city . ', ' . $this->faker->country,
            'package_type' => $this->faker->randomElement(['starter', 'professional', 'premium']),
            'price' => $this->faker->numberBetween(100, 5000),
            'status' => 'published',
            'published_at' => now(),
            'expires_at' => $this->faker->dateTimeBetween('+1 month', '+1 year'),
            'visibility' => $this->faker->randomElement(['public', 'private']),
        ];
    }
}
