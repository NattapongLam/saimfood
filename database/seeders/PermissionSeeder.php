<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'setup-machinegroup']);
        Permission::create(['name' => 'setup-machine']);
        Permission::create(['name' => 'setup-machineplaning']);
        Permission::create(['name' => 'setup-machinechecksheet']);
        Permission::create(['name' => 'setup-equipment']);
        Permission::create(['name' => 'setup-equipmentplaning']);
    }
}
