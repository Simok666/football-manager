<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            ['description' => 'G : Goal Keeper (Penjaga Gawang)'],
            ['description' => 'D: Defender (Pemain belakang)'],
            ['description' => 'M: Midfielder (Gelandang)'],
            ['description' => 'F: Forward (Pemain Depan)'],
        ]);
    }
}
