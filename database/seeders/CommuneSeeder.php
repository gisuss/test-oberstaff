<?php

namespace Database\Seeders;

use App\Models\Commune;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Commune::create([
            'id_reg' => 1,
            'description' => 'commune test'
        ]);
    }
}
