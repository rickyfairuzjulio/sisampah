<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'petugas']);
        Role::firstOrCreate(['name' => 'nasabah']);

        Permission::firstOrCreate(['name' => 'view_dashboard']);
        Permission::firstOrCreate(['name' => 'manage_harga']);
        Permission::firstOrCreate(['name' => 'manage_users']);
        Permission::firstOrCreate(['name' => 'manage_articles']);
        Permission::firstOrCreate(['name' => 'validate_withdrawal']);
        Permission::firstOrCreate(['name' => 'input_timbangan']);
        Permission::firstOrCreate(['name' => 'view_saldo']);
        Permission::firstOrCreate(['name' => 'request_withdrawal']);

        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        $petugasRole = Role::findByName('petugas');
        $petugasRole->givePermissionTo(['input_timbangan', 'view_dashboard']);

        $nasabahRole = Role::findByName('nasabah');
        $nasabahRole->givePermissionTo(['view_saldo', 'request_withdrawal', 'view_dashboard']);
    }
}
