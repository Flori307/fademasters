<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Мужская стрижка',
                'slug' => 'muzhskaya-strizhka',
                'description' => 'Классическая мужская стрижка с учётом пожеланий клиента',
                'duration_minutes' => 40,
                'price' => 1500,
                'category' => 'Стрижки',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Стрижка + борода',
                'slug' => 'strizhka-boroda',
                'description' => 'Полный комплекс: стрижка волос и уход за бородой',
                'duration_minutes' => 70,
                'price' => 2500,
                'category' => 'Комплекс',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Моделирование бороды',
                'slug' => 'modelirovanie-borody',
                'description' => 'Коррекция и моделирование бороды любой сложности',
                'duration_minutes' => 30,
                'price' => 1200,
                'category' => 'Борода',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Детская стрижка',
                'slug' => 'detskaya-strizhka',
                'description' => 'Стрижка для мальчиков до 12 лет',
                'duration_minutes' => 30,
                'price' => 1000,
                'category' => 'Детям',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Fade стрижка',
                'slug' => 'fade-strizhka',
                'description' => 'Современная стрижка с плавным переходом',
                'duration_minutes' => 50,
                'price' => 1800,
                'category' => 'Стрижки',
                'is_active' => true,
                'sort_order' => 5,
            ],
            
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}