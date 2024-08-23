<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TypeSupplyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_supplier')->insert([
            'name' => 'T1'

        ]);
        DB::table('type_supplier')->insert([
            'name' => 'T2'

        ]);
    }
}
