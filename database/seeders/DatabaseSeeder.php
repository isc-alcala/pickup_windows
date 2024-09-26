<?php

namespace Database\Seeders;

use App\Models\TypeSupplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        $this->call(RoleSeeder::class);
        $this->call(TiporutaTableseeder::class);
        $this->call(EstatusSeeder::class);
        $this->call(TypeSupplyerSeeder::class);
        $this->call(UsuariotableSeeder::class);
        $this->call(TransicionesSeeder::class);
    }
}
