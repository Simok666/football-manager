<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contributions')->insert([
            ['description' => 'Paid off (lunas)'],
            ['description' => 'On bill (pada periode pembayaran belum dibayar)'],
            ['description' => 'Overdue (tunggakan lebih dari 1 bulan)'],
        ]);
    }
}
