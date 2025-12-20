<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the ticket seeder to create 500 users with tickets
        $this->call(TicketSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(UserSeeder::class);
    }
}
