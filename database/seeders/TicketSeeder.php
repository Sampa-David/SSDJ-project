<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if seeding has already been done
        if (User::count() > 0) {
            $this->command->info('ℹ️  Database already seeded. Skipping TicketSeeder to avoid duplicates.');
            return;
        }

        // Define ticket types and their prices
        $ticketTypes = [
            'standard' => 150,
            'vip' => 300,
            'premium' => 500,
            'gold' => 750,
            'platinum' => 1000,
        ];

        $ticketStatuses = ['active', 'cancelled', 'used'];

        $this->command->info('🌱 Starting to seed 500 users with tickets...');

        // Create 500 users with tickets
        for ($i = 1; $i <= 500; $i++) {
            $user = User::create([
                'name' => "User $i",
                'email' => "user{$i}@example.com",
                'password' => Hash::make('password123'),
                'phone' => '0' . rand(600000000, 699999999),
                'company' => rand(0, 1) ? "Company " . chr(65 + ($i % 26)) : null,
                'email_verified_at' => now(),
            ]);

            // Each user gets 1-3 tickets
            $ticketCount = rand(1, 3);
            for ($j = 0; $j < $ticketCount; $j++) {
                $ticketType = array_rand($ticketTypes);
                $price = $ticketTypes[$ticketType];
                $status = $ticketStatuses[array_rand($ticketStatuses)];

                // Generate random purchase date within last 6 months
                $purchasedAt = Carbon::now()->subDays(rand(0, 180));
                $validFrom = $purchasedAt->copy();
                $validUntil = $purchasedAt->copy()->addDays(rand(30, 90));

                Ticket::create([
                    'user_id' => $user->id,
                    'ticket_type' => $ticketType,
                    'price' => $price,
                    'quantity' => rand(1, 4),
                    'status' => $status,
                    'purchase_date' => $purchasedAt,
                    'valid_from' => $validFrom,
                    'valid_until' => $validUntil,
                    'notes' => "Ticket for user {$i}",
                ]);
            }

            // Print progress
            if ($i % 100 == 0) {
                $this->command->info("✓ Created {$i} users with tickets...");
            }
        }

        $this->command->info('✅ Successfully seeded 500 users with various tickets!');
    }
}

                

