<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            [ 'description' => 'Valencia Norte' ],
            [ 'description' => 'Valencia Sur' ],
            [ 'description' => 'Naguanagua' ],
            [ 'description' => 'Los Guayos' ],
            [ 'description' => 'Guacara' ],
            [ 'description' => 'Ciudad Alianza' ],
            [ 'description' => 'Paraparal' ],
            [ 'description' => 'Plaza de Toros' ],
            [ 'description' => 'La Isabelica' ],
            [ 'description' => 'Puerto Cabello' ],
            [ 'description' => 'Morón' ],
            [ 'description' => 'San Joaquín' ],
            [ 'description' => 'Mariara' ],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
