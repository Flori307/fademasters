<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Создаём роли
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'barber']);
        Role::create(['name' => 'client']);
        
        // Создаём разрешения (опционально)
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage appointments']);
        
        // Назначаем разрешения админу
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(['manage users', 'manage appointments']);
    }
}