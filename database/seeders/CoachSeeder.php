<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coach;

class CoachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coach::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123')
        ]);

        Coach::create([
            'name' => 'Jane Smith',
            'email' => 'janesmith@example.com',
            'password' => bcrypt('password123')
        ]);

        Coach::create([
            'name' => 'Emily Johnson',
            'email' => 'emilyjohnson@example.com',
            'password' => bcrypt('password123')
        ]);
    }
}
