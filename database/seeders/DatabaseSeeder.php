<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Сначала создаём роли
        $this->call(RolesAndPermissionsSeeder::class);
        
        // Создаём админа
        $admin = User::create([
            'name' => 'Администратор',
            'email' => 'admin@fademasters.ru',
            'password' => bcrypt('admin123'),
        ]);
        $admin->assignRole('admin');
        
        // Создаём тестового клиента
        $client = User::create([
            'name' => 'Тестовый Клиент',
            'email' => 'client@fademasters.ru',
            'phone' => '+7 (999) 123-45-67',
            'password' => bcrypt('client123'),
        ]);
        $client->assignRole('client');

        // Создаём услуги
        $this->call(ServicesTableSeeder::class);
        $this->call(AdditionalServicesTableSeeder::class);
        
        // Создаём барберов
        $this->call(BarbersTableSeeder::class);
        
        // Создаём отзывы
        $this->call(ReviewsTableSeeder::class);
    }
}