<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['description' => 'Trial'],
            ['description' => 'Member Active (MA)'],
            ['description' => 'Member Non-Active (MNA)'],
        ]);
    }
}
