<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée 10 utilisateurs (ou adapte selon besoin)
        $users = User::factory()->count(10)->create();

        // Crée 30 événements, chacun assigné à un utilisateur aléatoire
        foreach (range(1, 30) as $i) {
            Event::create([
                'user_id' => $users->random()->id,
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
            ]);
        }
    }
}
