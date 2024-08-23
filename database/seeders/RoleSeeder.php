<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Operaciones']);
        $role3 = Role::create(['name' => 'Embarques']);
        $role4 = Role::create(['name' => 'Caseta']);
        Permission::create(['name' => 'all.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'all.destroy'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'truck.status.cancelar'])->syncRoles([$role1,$role2,$role3,$role4]);
        Permission::create(['name' => 'truck.status.entrada'])->syncRoles([$role1,$role4]);
        Permission::create(['name' => 'truck.status.rampa'])->syncRoles([$role1,$role3]);
        Permission::create(['name' => 'truck.status.cargado'])->syncRoles([$role1,$role3]);
        Permission::create(['name' => 'truck.status.salida'])->syncRoles([$role1,$role4]);
    }
}
