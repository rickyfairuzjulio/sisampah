<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'petugas']);
        Role::create(['name' => 'nasabah']);

        Permission::create(['name' => 'view_dashboard']);
        Permission::create(['name' => 'manage_harga']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_articles']);
        Permission::create(['name' => 'validate_withdrawal']);
        Permission::create(['name' => 'input_timbangan']);
        Permission::create(['name' => 'view_saldo']);
        Permission::create(['name' => 'request_withdrawal']);

        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $petugasRole = Role::findByName('petugas');
        $petugasRole->givePermissionTo(['input_timbangan', 'view_dashboard']);

        $nasabahRole = Role::findByName('nasabah');
        $nasabahRole->givePermissionTo(['view_saldo', 'request_withdrawal', 'view_dashboard']);
    }
}
