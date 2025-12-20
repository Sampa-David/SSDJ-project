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
            'name' => fake('fr_FR')->sentence(3),
            'description' => fake('fr_FR')->sentence(10),
            'date_event' => fake('fr_FR')->dateTimeBetween('now', '+1 year'),
            'location' => fake('fr_FR')->city . ', ' . fake('fr_FR')->country,
            'package_type' => fake('fr_FR')->randomElement(['starter', 'professional', 'premium']),
            'price' => fake('fr_FR')->numberBetween(100, 5000),
            'status' => 'published',
            'published_at' => now(),
            'expires_at' => fake('fr_FR')->dateTimeBetween('+1 month', '+1 year'),
            'visibility' => fake('fr_FR')->randomElement(['public', 'private']),
        ];
    }
}
