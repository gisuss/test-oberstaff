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
        $comunas = [
            [ 'id_reg' => 1, 'description' => 'Comuna de Prebo' ],
            [ 'id_reg' => 1, 'description' => 'Comuna Organizada Guataparo' ],
            [ 'id_reg' => 2, 'description' => 'Comuna del Sur' ],
            [ 'id_reg' => 3, 'description' => 'Comuna Negra Hippolita' ],
            [ 'id_reg' => 4, 'description' => 'Comuna El Robles I' ],
            [ 'id_reg' => 5, 'description' => 'Comuna El Samán' ],
            [ 'id_reg' => 6, 'description' => 'Comuna Sector 1' ],
            [ 'id_reg' => 6, 'description' => 'Comuna Sector 2' ],
            [ 'id_reg' => 6, 'description' => 'Comuna Sector 3' ],
            [ 'id_reg' => 7, 'description' => 'Comuna Unica del faro' ],
            [ 'id_reg' => 8, 'description' => 'Comuna El Chirino' ],
            [ 'id_reg' => 9, 'description' => 'Comuna Parque Valencia 1' ],
            [ 'id_reg' => 9, 'description' => 'Comuna Parque Valencia 2' ],
            [ 'id_reg' => 10, 'description' => 'Comuna La Entrada' ],
            [ 'id_reg' => 11, 'description' => 'Comuna El Pezcadito' ],
            [ 'id_reg' => 12, 'description' => 'Comuna Los Robles' ],
            [ 'id_reg' => 13, 'description' => 'Comuna Sector Saime' ],
        ];

        foreach ($comunas as $comuna) {
            Commune::create($comuna);
        }
    }
}
