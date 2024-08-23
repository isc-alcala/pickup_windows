<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuariotableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Miguel  ',
            'email' => 'admin.admin@ykm.com.mx',
            'password' => bcrypt('123'),
        ])->assignRole('Admin');
        User::create([
            'name' => 'Victor Rivera  ',
            'email' => 'operaciones@operaciones.com',
            'password' => bcrypt('123'),
        ])->assignRole('Operaciones');
        User::create([
            'name' => 'Embarques  ',
            'email' => 'embarques@embarques.com',
            'password' => bcrypt('123'),
        ])->assignRole('Embarques');
        User::create([
            'name' => 'Caseta  ',
            'email' => 'caseta@caseta.com',
            'password' => bcrypt('123'),
        ])->assignRole('Caseta');
    }
}
