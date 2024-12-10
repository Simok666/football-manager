<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PositionSeeder;
use Database\Seeders\ContributionSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CoachSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(PositionSeeder::class);
        $this->call(ContributionSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CoachSeeder::class);
    }
}
