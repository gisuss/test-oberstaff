<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'Oberstaff',
            'dni' => '20753800',
            'email' => 'admin@example.com',
            'address' => 'Naguanagua, Carabobo',
            'password'  =>  Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'date_reg' => Carbon::now()->format('d/m/Y H:i'),
            'id_com' => 1,
            'id_reg' => 1,
        ]);
    }
}
