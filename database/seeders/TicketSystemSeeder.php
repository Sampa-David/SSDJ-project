<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ticket;

class TicketSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users
        $users = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => bcrypt('password123'),
                'phone' => '+1-555-0101',
                'company' => 'Tech Innovations Inc',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@example.com',
                'password' => bcrypt('password123'),
                'phone' => '+1-555-0102',
                'company' => 'Digital Solutions Ltd',
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol@example.com',
                'password' => bcrypt('password123'),
                'phone' => '+1-555-0103',
                'company' => 'Cloud Systems Corp',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'password' => bcrypt('password123'),
                'phone' => '+1-555-0104',
                'company' => 'AI Ventures',
            ],
            [
                'name' => 'Emma Martinez',
                'email' => 'emma@example.com',
                'password' => bcrypt('password123'),
                'phone' => '+1-555-0105',
                'company' => 'Data Analytics Pro',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Create random number of tickets for each user
            $ticketCount = rand(1, 5);

            for ($i = 0; $i < $ticketCount; $i++) {
                $ticketType = $this->getRandomTicketType();
                $price = $this->getPriceForType($ticketType);

                Ticket::create([
                    'user_id' => $user->id,
                    'ticket_type' => $ticketType,
                    'price' => $price,
                    'ticket_number' => Ticket::generateTicketNumber(),
                    'status' => $this->getRandomStatus(),
                    'purchased_at' => now()->subDays(rand(1, 30)),
                    'valid_from' => now()->subDays(rand(0, 10)),
                    'valid_until' => now()->addDays(rand(60, 180)),
                    'qr_code' => base64_encode(uniqid('ticket_', true)),
                    'notes' => $this->getRandomNotes(),
                ]);
            }
        }

        $this->command->info('✅ Test users and tickets created successfully!');
        $this->command->info(sprintf('📊 Created %d users with %d total tickets', count($users), Ticket::count()));
    }

    /**
     * Get random ticket type
     */
    private function getRandomTicketType(): string
    {
        $types = ['early_bird', 'regular', 'premium'];
        return $types[array_rand($types)];
    }

    /**
     * Get price for ticket type
     */
    private function getPriceForType(string $type): float
    {
        return match ($type) {
            'early_bird' => 75.00,
            'regular' => 125.00,
            'premium' => 195.00,
            default => 125.00,
        };
    }

    /**
     * Get random status
     */
    private function getRandomStatus(): string
    {
        $statuses = ['active', 'active', 'active', 'active', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Get random notes
     */
    private function getRandomNotes(): ?string
    {
        $notes = [
            'VIP access included',
            'Includes breakfast',
            'Networking event pass included',
            'Premium seat location',
            'Early bird special pricing',
            null,
            null,
        ];

        return $notes[array_rand($notes)];
    }
}
